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
    private const PROVIDERS = [
        'facebook' => \Bow\Soauth\Provider\FacebookProvider::class,
        'gitlab' => \Bow\Soauth\Provider\GitlabProvider::class,
        'github' => \Bow\Soauth\Provider\GithubProvider::class
    ];

    /**
     * The soauth provider config
     *
     * @var array
     */
    private static array $config;

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
    public static function redirect(string $provider, array $scope = []): string
    {
        return static::provider($provider)->redirect($scope);
    }

    /**
     * Load user resource
     *
     * @param string $provider
     * @return UserResource
     */
    public static function resource(string $provider): UserResource
    {
        return static::provider($provider)->process();
    }

    /**
     * Make provider
     *
     * @param string $provider
     * @return AbstractProvider
     */
    private static function provider(string $name): AbstractProvider
    {
        $config = static::$config[$name] ?? null;

        if (!$config) {
            throw new SoauthException("Configuration not exists for the provider $name");
        }

        $provider = static::PROVIDERS[$name];

        return new $provider($config);
    }
}
