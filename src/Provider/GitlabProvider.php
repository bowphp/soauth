<?php

declare(strict_types=1);

namespace Bow\Soauth\Provider;

use Bow\Soauth\UserResource;
use League\OAuth2\Client\Token\AccessTokenInterface;
use Omines\OAuth2\Client\Provider\Gitlab;

final class GitlabProvider extends AbstractProvider
{
    /** @param array{client_id:string,client_secret:string,redirect_uri:string,domain?:string} $config */
    public function __construct(array $config)
    {
        $this->provider = new Gitlab([
            'clientId'     => $config['client_id'],
            'clientSecret' => $config['client_secret'],
            'redirectUri'  => $config['redirect_uri'],
            'domain'       => $config['domain'] ?? 'https://gitlab.com',
        ]);
    }

    public function getResource(AccessTokenInterface $access_token): UserResource
    {
        $resource = $this->provider->getResourceOwner($access_token);

        return new UserResource($resource->toArray());
    }
}
