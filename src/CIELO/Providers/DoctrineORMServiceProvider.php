<?php

namespace CIELO\Providers;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class DoctrineORMServiceProvider
 * @package CIELO\Providers
 */
class DoctrineORMServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        //Doctrine config
        $isDevMode = true;
        $params = parse_ini_file(__DIR__ . DIRECTORY_SEPARATOR . '../../../config.ini', true);

        if(is_null($params['DATABASE']))
            throw new \Exception("Conexão não configurada no arquivo config.ini");

        if(is_null($params['EDI_DIRECTORIES']))
            throw new \Exception("Diretórios não configurado no arquivo config.ini");

        foreach($params['EDI_DIRECTORIES'] as $key => $value){
            putenv("{$key}={$value}");
        }
        $params['DATABASE']['driverOptions'] = [
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
        ];
        $config = Setup::createConfiguration($isDevMode);
        $driver = new AnnotationDriver(new AnnotationReader(), [
            __DIR__ . DIRECTORY_SEPARATOR . '../v001/Entity'
        ]);
        AnnotationRegistry::registerLoader('class_exists');
        $config->setMetadataDriverImpl($driver);

        $arrayCache = new ArrayCache();
        $config->setQueryCacheImpl($arrayCache);

        $em = EntityManager::create($params['DATABASE'], $config);

        $em->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('set', 'string');
        $em->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

        $container['em'] = $container->factory(function() use ($em){
            return $em;
        });
    }

}