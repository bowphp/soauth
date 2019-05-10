<?php

namespace Bow\Soauth;

class UserResource
{
    /**
     * User information collection
     *
     * @var array
     */
    private $config;

    /**
     * UserResource contructor
     *
     * @param array $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * Get the user name
     *
     * @return string
     */
    public function getName()
    {
        return $this->config['name'] ?? null;
    }

    /**
     * Get the user email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->config['email'] ?? null;
    }

    /**
     * Get the user avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->config['avatar'] ?? null;
    }

    /**
     * Get the user Nickname
     *
     * @return string
     */
    public function getNickname()
    {
        return $this->config['nickname'] ?? null;
    }
}
