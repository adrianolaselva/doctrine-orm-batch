<?php
/**
 * Created by PhpStorm.
 * User: Adriano
 * Date: 12/07/2016
 * Time: 22:44
 */

namespace CIELO\Providers;


use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceContainer extends Container implements ServiceContainerInterface
{
    private $providers = [];

    public function registerProvider(ServiceProviderInterface $serviceProvider)
    {
        $this->providers[] = $serviceProvider;
        $serviceProvider->register($this);
    }

    public function terminate(){
        foreach ($this->providers as $provider) {
            $provider->terminate($this);
        }
    }

}