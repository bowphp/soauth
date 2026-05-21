<?php

namespace Bow\Soauth\Provider;

use Bow\Soauth\UserResource;
use Bow\Soauth\Exception\SoauthException;
use League\OAuth2\Client\Provider\AbstractProvider as LeagueOAuth2AbstractProvider;
use League\OAuth2\Client\Token\AccessTokenInterface;

abstract class AbstractProvider
{
    /**
     * Session key holding the CSRF state generated at redirect time.
     */
    private const STATE_SESSION_KEY = 'oauth2_state';

    /**
     * The provider config instance
     *
     * @var LeagueOAuth2AbstractProvider
     */
    protected LeagueOAuth2AbstractProvider $provider;

    /**
     * Build the authorisation URL, stash the CSRF state, and return a
     * redirect response to the provider's consent screen.
     *
     * @param list<string> $scope
     */
    public function redirect(array $scope = []): mixed
    {
        // We get the redirect url generate for you
        $authorization_url = $this->provider->getAuthorizationUrl(
            ['scope' => $scope]
        );

        // We get the state generated for you and
        // store it to the session.
        session()->add(self::STATE_SESSION_KEY, $this->provider->getState());

        return redirect($authorization_url);
    }

    /**
     * Handle the OAuth callback: validate the CSRF state, exchange the
     * authorisation code for an access token, and resolve the user resource.
     *
     * @throws SoauthException when the state is missing/mismatched, when the
     *                         authorisation code is absent, or when the state
     *                         hasn't been seeded by a prior redirect().
     */
    public function resource(): UserResource
    {
        $request = request();

        $expectedState = session()->get(self::STATE_SESSION_KEY);
        $receivedState = $request->get('state');

        // The state MUST have been seeded by a prior redirect(), and the
        // callback MUST echo it back. Comparing two nulls with !== returns
        // false, which would otherwise let an attacker bypass CSRF protection
        // by hitting the callback URL directly.
        if (!is_string($expectedState) || $expectedState === ''
            || !is_string($receivedState)
            || !hash_equals($expectedState, $receivedState)
        ) {
            session()->remove(self::STATE_SESSION_KEY);
            throw new SoauthException('The oauth session is corrupted or expired.');
        }

        // Single-use state — wipe it so a replayed callback cannot reuse it.
        session()->remove(self::STATE_SESSION_KEY);

        $code = $request->get('code');
        if (!is_string($code) || $code === '') {
            throw new SoauthException('Missing authorisation code in OAuth callback.');
        }

        // Exchange the code for an access token, then resolve the user.
        $access_token = $this->provider->getAccessToken('authorization_code', [
            'code' => $code,
        ]);

        return $this->getResource($access_token);
    }

    /**
     * Provider-specific resource resolution. Implementations call the
     * League provider's `getResourceOwner($accessToken)` and wrap the
     * returned data in a UserResource.
     */
    abstract public function getResource(AccessTokenInterface $access_token): UserResource;
}
