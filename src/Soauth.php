<?php

namespace Bow\Soauth;

use Bow\Soauth\Exception\SoauthException;
use Bow\Soauth\Provider\AbstractProvider;

class Soauth
{
    /**
     * Provider name → concrete AbstractProvider subclass.
     *
     * @var array<string, class-string<AbstractProvider>>
     */
    private static array $providers = [
        'facebook'  => Provider\FacebookProvider::class,
        'gitlab'    => Provider\GitlabProvider::class,
        'github'    => Provider\GithubProvider::class,
        'google'    => Provider\GoogleProvider::class,
        'linkedin'  => Provider\LinkedinProvider::class,
        'instagram' => Provider\InstagramProvider::class,
    ];

    /**
     * Per-provider credentials (client_id / client_secret / redirect_uri),
     * keyed by provider name.
     *
     * @var array<string, array<string, mixed>>
     */
    private static array $config = [];

    /**
     * Seed the per-provider credentials. Usually called once at boot by
     * SoauthConfiguration with the contents of `config/soauth.php`.
     *
     * @param array<string, array<string, mixed>> $config
     */
    public static function configure(array $config): void
    {
        self::$config = $config;
    }

    /**
     * Redirect the user to the provider's consent screen.
     *
     * @param list<string> $scope
     */
    public static function redirect(string $provider, array $scope = []): mixed
    {
        return self::provider($provider)->redirect($scope);
    }

    /**
     * Handle the provider callback and return the authenticated user.
     */
    public static function resource(string $provider): UserResource
    {
        return self::provider($provider)->resource();
    }

    /**
     * Resolve and instantiate the configured provider, with a clear error
     * when the name is unknown or the credentials block is missing.
     */
    private static function provider(string $name): AbstractProvider
    {
        if (!isset(self::$providers[$name])) {
            throw new SoauthException(sprintf(
                'Unknown soauth provider "%s". Supported: %s.',
                $name,
                implode(', ', array_keys(self::$providers)),
            ));
        }

        if (!isset(self::$config[$name]) || !is_array(self::$config[$name])) {
            throw new SoauthException(sprintf(
                'Soauth provider "%s" is not configured. '
                . 'Set config(\'soauth.%s\') (client_id, client_secret, redirect_uri).',
                $name,
                $name,
            ));
        }

        $class = self::$providers[$name];

        return new $class(self::$config[$name]);
    }
}
