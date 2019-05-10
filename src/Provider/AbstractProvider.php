<?php

namespace Bow\Saauth\Provider;

use Bow\Saauth\UserResource;
use League\OAuth2\Client\Provider\GenericProvider as LeagueOAuth2ClientProvider;

abstract class AbstractProvider
{
    /**
     * The provider config instance
     *
     * @var LeagueOAuth2ClientProvider
     */
    private $provider;

    public function __construc($config)
    {
        $this->provider = new LeagueOAuth2ClientProvider([
            'clientId' => $config['client_id']
            'clientSecret' => $config['client_secret'],
            'redirectUri' => $config['redirect_url']
        ]);
    }

    /**
     * Get redirect url
     *
     * @return string
     */
    public function redirect($scope = [])
    {
        // We get the redirect url generate for you
        $authorization_url = $this->provider->getAuthorizationUrl(
            ['scope' => $this->scope]
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
        if ($request->get('state') !== $request->session()->get('oauth2_state')) {
            // Todo: throw error here
            return;
        }

        // We try to get an access token using the authorization code grant.
        $access_token = $this->provider
            ->getAccessToken('authorization_code', [
                'code' => $request->get('code')
            ]);

        // We get use resouece
        return $this->getResource();
    }

    /**
     * Get the user resource
     *
     * @return UserResource
     */
    abstract public function getResource();
}
