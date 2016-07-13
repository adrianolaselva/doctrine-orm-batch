<?php
/**
 * Created by PhpStorm.
 * User: Adriano
 * Date: 12/07/2016
 * Time: 22:44
 */

namespace CIELO\Providers;

use Pimple\ServiceProviderInterface;

/**
 * Interface ServiceContainerInterface
 * @package CIELO\Providers
 */
interface ServiceContainerInterface
{
    public function registerProvider(ServiceProviderInterface $serviceProvider);
}