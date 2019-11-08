<?php

namespace Bow\Soauth;

class UserResource
{
    /**
     * User information collection
     *
     * @var array
     */
    private $attributes;

    /**
     * UserResource contructor
     *
     * @param array $attributes
     * @return void
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Get the user name
     *
     * @return string
     */
    public function getName()
    {
        return $this->attributes['name'] ?? null;
    }

    /**
     * Get the user email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->attributes['email'] ?? null;
    }

    /**
     * Get the user avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->attributes['avatar'] ?? null;
    }

    /**
     * Get the user Nickname
     *
     * @return string
     */
    public function getNickname()
    {
        return $this->attributes['nickname'] ?? null;
    }
}
