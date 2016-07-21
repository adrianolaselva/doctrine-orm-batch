<?php

namespace CIELO\Factories;

use CIELO\Constants\Versao;
use CIELO\Providers\DoctrineORMServiceProvider;
use CIELO\Providers\ServiceContainer;
use CIELO\v001\WorkerV001;
use Exception;

/**
 * Class WorkerFactory
 * @package CIELO\Factories
 */
class WorkerFactory
{

    public static function getInstance($versao){

        $container = new ServiceContainer();
        $container->register(new DoctrineORMServiceProvider());

        switch($versao){
            case Versao::CIELO_VERSAO_001: return new WorkerV001($container['em']);
        }

        throw new Exception("Versão de EDI não implementada");
    }
}