<?php

namespace Bow\Soauth\Provider;

use Bow\Soauth\UserResource;
use League\OAuth2\Client\Provider\LinkedIn;
use League\OAuth2\Client\Token\AccessTokenInterface;

class LinkedinProvider extends AbstractProvider
{
    /**
     * AbstractProvider constructor
     *
     * @param array $config
     * @return void
     */
    public function __construct($config)
    {
        $this->provider = new LinkedIn([
            'clientId' => $config['client_id'],
            'clientSecret' => $config['client_secret'],
            'redirectUri' => $config['redirect_uri']
        ]);
    }

    /**
     * Get the user resource
     *
     * @return UserResource
     */
    public function getResource(AccessTokenInterface $access_token)
    {
        $resource = $this->provider
            ->getResourceOwner($access_token);

        return new UserResource($resource->toArray());
    }
}
