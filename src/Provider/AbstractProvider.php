<?php

namespace Bow\Soauth\Provider;

use Bow\Soauth\UserResource;
use Bow\Soauth\Exception\SoauthException;
use League\OAuth2\Client\Provider\AbstractProvider as LeagueOAuth2AbstractProvider;
use League\OAuth2\Client\Token\AccessTokenInterface;

abstract class AbstractProvider
{
    /**
     * The provider config instance
     *
     * @var LeagueOAuth2AbstractProvider
     */
    protected LeagueOAuth2AbstractProvider $provider;

    /**
     * Get redirect url
     *
     * @return string
     */
    public function redirect($scope = [])
    {
        // We get the redirect url generate for you
        $authorization_url = $this->provider->getAuthorizationUrl(
            ['scope' => $scope]
        );

        // We get the state generated for you and
        // store it to the session.
        session('oauth2_state', $this->provider->getState());

        return redirect($authorization_url);
    }

    /**
     * Process the request
     *
     * @return UserResource
     */
    public function process()
    {
        $request = request();
    
        // Check request state and saved state
        if ($request->get('state') !== session()->get('oauth2_state')) {
            throw new SoauthException("The oauth session corrupted");
        }

        // We try to get an access token using the authorization code grant.
        $access_token = $this->provider
            ->getAccessToken('authorization_code', [
                'code' => $request->get('code')
            ]);

        // We get use resouece
        return $this->getResource($access_token);
    }

    /**
     * Get the user resource
     *
     * @return UserResource
     */
    abstract public function getResource(AccessTokenInterface $access_token);
}
