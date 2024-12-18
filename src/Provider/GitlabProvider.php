<?php

namespace Bow\Soauth\Provider;

use Bow\Soauth\UserResource;
use League\OAuth2\Client\Token\AccessTokenInterface;
use Omines\OAuth2\Client\Provider\Gitlab;

class GitlabProvider extends AbstractProvider
{
    /**
     * AbstractProvider constructor
     *
     * @param array $config
     * @return void
     */
    public function __construct($config)
    {
        $this->provider = new Gitlab([
            'clientId' => $config['client_id'],
            'clientSecret' => $config['client_secret'],
            'redirectUri' => $config['redirect_url']
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
