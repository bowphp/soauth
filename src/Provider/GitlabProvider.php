<?php

namespace Bow\Soauth\Provider;

use Bow\Soauth\UserResource;

class GitlabProvider extends AbstractProvider
{
    /**
     * Get the user resource
     *
     * @return UserResource
     */
    public function getResource()
    {
        $resource = $this->provider
            ->getResourceOwner($access_token);

        return new UserResource($resource->toArray())
    }
}
