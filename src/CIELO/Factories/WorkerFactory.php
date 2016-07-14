<?php

namespace CIELO\Factories;

use CIELO\Constants\Versao;
use CIELO\v001\WorkerV001;
use Exception;

/**
 * Class WorkerFactory
 * @package CIELO\Factories
 */
class WorkerFactory
{
    public static function getInstance($versao){
        switch($versao){
            case Versao::CIELO_VERSAO_001: return new WorkerV001();
        }

        throw new Exception("Versão de EDI não implementada");
    }
}