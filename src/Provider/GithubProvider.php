<?php

declare(strict_types=1);

namespace Bow\Soauth\Provider;

use Bow\Soauth\UserResource;
use League\OAuth2\Client\Provider\Github;
use League\OAuth2\Client\Token\AccessTokenInterface;

final class GithubProvider extends AbstractProvider
{
    /** @param array{client_id:string,client_secret:string,redirect_uri:string} $config */
    public function __construct(array $config)
    {
        $this->provider = new Github([
            'clientId'     => $config['client_id'],
            'clientSecret' => $config['client_secret'],
            'redirectUri'  => $config['redirect_uri'],
        ]);
    }

    public function getResource(AccessTokenInterface $access_token): UserResource
    {
        $resource = $this->provider->getResourceOwner($access_token);

        return new UserResource($resource->toArray());
    }
}
