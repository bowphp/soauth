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
    private $providers = [
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
    public function configure($config)
    {
        $this->config = $config;
    }

    /**
     * Make redirect
     *
     * @param string $provider
     * @return string
     */
    public static function redirect($provider)
    {
        return static::provider($provider)->redirect();
    }

    /**
     * Load user resource
     *
     * @param string $provider
     * @return UserResource
     */
    public static function resource($provider)
    {
        return static::provider($provider)->process();
    }

    /**
     * Make provider
     *
     * @param strinf $provider
     * @return ProviderConfiguration
     */
    private static function provider($provider)
    {
        $config = $this->config[$provider];

        return new $this->providers[$provider]($config);
    }
}
