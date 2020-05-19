<?php

namespace Bow\Soauth\Provider;

use Bow\Soauth\UserResource;

class GithubProvider extends AbstractProvider
{
    /**
     * Get the user resource
     * 
     * @param string $access_token
     * @return UserResource
     */
    public function getResource($access_token)
    {
        $resource = $this->provider
            ->getResourceOwner($access_token);

        return new UserResource($resource->toArray());
    }
}
