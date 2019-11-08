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
     * @return mixed
     */
    public function create(Loader $config)
    {
        $soauth = (array) $config['soauth'];

        $soauth = array_merge(
            require __DIR__.'/../config/soauth.php',
            $soauth
        );

        $config['soauth'] = $soauth;

        $this->container->bind('soauth', function () use ($config) {
            return Soauth::configure($config['soauth']);
        });
    }

    /**
     * Launch configuration
     *
     * @return mixed
     */
    public function run()
    {
        return $this->container->make('soauth')
    }
}
