<?php

namespace CIELO\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class DoctrineORMServiceProvider
 * @package CIELO\Providers
 */
class DoctrineORMServiceProvider extends Container implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        //Configurações de log
        \Logger::configure(__DIR__ . DIRECTORY_SEPARATOR . '../../../config.xml');

        //Doctrine config
        $isDevMode = true;
        $connectionParams = parse_ini_file(
            __DIR__ . DIRECTORY_SEPARATOR . '../../../config.ini'
        );
        $connectionParams['driverOptions'] = [
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
        ];
        $config = \Doctrine\ORM\Tools\Setup::createConfiguration($isDevMode);
        $driver = new \Doctrine\ORM\Mapping\Driver\AnnotationDriver(new \Doctrine\Common\Annotations\AnnotationReader(), [
            __DIR__ . DIRECTORY_SEPARATOR . '../v001/Entity'
        ]);
        \Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');
        $config->setMetadataDriverImpl($driver);

        $em = \Doctrine\ORM\EntityManager::create($connectionParams, $config);

        $em->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('set', 'string');
        $em->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

        $container['em'] = $container->factory(function() use ($em){
            return $em;
        });
    }

}