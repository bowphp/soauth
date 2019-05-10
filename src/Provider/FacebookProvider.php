<?php

namespace Bow\Soauth\Provider;

use Bow\Soauth\UserResource;

class FacebookProvider extends AbstractProvider
{
    /**
     * Get the user resource
     *
     * @param mixed $oauth
     * @return UserResource
     */
    public function getResource($oauth)
    {
        $resource = $this->oauth
            ->getResourceOwner($access_token);

        return new UserResource($resource->toArray())
    }
}