<?php

namespace Bow\Soauth;

use Bow\Soauth\Provider\AbstractProvider;

class Soauth
{
    /**
     * The providers
     *
     * @var array
     */
    private static $providers = [
        'facebook' => \Bow\Soauth\Provider\FacebookProvider::class,
        'gitlab' => \Bow\Soauth\Provider\GitlabProvider::class,
        'github' => \Bow\Soauth\Provider\GithubProvider::class,
        'google' => \Bow\Soauth\Provider\GoogleProvider::class,
        'linkedin' => \Bow\Soauth\Provider\LinkedinProvider::class,
        'instagram' => \Bow\Soauth\Provider\InstagramProvider::class,
    ];

    /**
     * The soauth provider config
     *
     * @var array
     */
    private static $config;

    /**
     * Make Soauth configuration
     *
     * @param array $config
     * @return void
     */
    public static function configure(array $config)
    {
        static::$config = $config;
    }

    /**
     * Make redirect
     *
     * @param string $provider
     * @param array $scope
     * @return string
     */
    public static function redirect($provider, $scope = [])
    {
        return static::provider($provider)->redirect($scope);
    }

    /**
     * Load user resource
     *
     * @param string $provider
     * @return UserResource
     */
    public static function resource(string $provider)
    {
        return static::provider($provider)->process();
    }

    /**
     * Make provider
     *
     * @param string $provider
     * @return AbstractProvider
     */
    private static function provider(string $provider): AbstractProvider
    {
        $config = static::$config[$provider];

        return new static::$providers[$provider]($config);
    }
}
