<?php

namespace Bow\Soauth\Provider;

use Bow\Soauth\UserResource;
use League\OAuth2\Client\Token\AccessTokenInterface;

class GitlabProvider extends AbstractProvider
{
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
