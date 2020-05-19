<?php

namespace Bow\Soauth;

use Bow\Http\Request;

class Soauth
{
    /**
     * The providers
     *
     * @var array
     */
    const PROVIDERS = [
        'facebook' => \Bow\Soauth\Provider\FacebookProvider::class,
        'gitlab' => \Bow\Soauth\Provider\GitlabProvider::class,
        'github' => \Bow\Soauth\Provider\GithubProvider::class
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
     * @return Soauth
     */
    public static function configure($config)
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
     * @return ProviderConfiguration
     */
    private static function provider(string $name)
    {
        $config = static::$config[$name];
        $provider = Soauth::PROVIDERS[$name];

        return new $provider($config);
    }
}
