<?php

namespace Bow\Soauth;

use Bow\Configuration\Loader;
use Bow\Configuration\Configuration;

class SoauthConfiguration extends Configuration
{
    /**
     * Create the configuration
     *
     * @param Loader $config
     * @return void
     */
    public function create(Loader $config): void
    {
        $soauth = (array) $config['soauth'];

        $soauth = array_merge(
            require __DIR__.'/../config/soauth.php',
            $soauth
        );

        $config['soauth'] = $soauth;

        $this->container->bind('soauth', function () use ($config) {
            return Soauth::configure((array) $config['soauth']);
        });
    }

    /**
     * Launch configuration
     *
     * @return void
     */
    public function run(): void
    {
        $this->container->make('soauth');
    }
}
