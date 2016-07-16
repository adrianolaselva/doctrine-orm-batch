<?php

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$container = new \Pimple\Container();
$container->register(new \CIELO\Providers\DoctrineORMServiceProvider());

//carrega configurações

if(!is_file(__DIR__ . DIRECTORY_SEPARATOR . 'config.ini'))
    throw new \Exception("Arquivo config.ini não encontrato");

$params = parse_ini_file(__DIR__ . DIRECTORY_SEPARATOR . 'config.ini', true);
foreach($params['EDI_DIRECTORIES'] as $key => $value){
    putenv("{$key}={$value}");
}

$worker = \CIELO\Factories\WorkerFactory::getInstance(\CIELO\Constants\Versao::CIELO_VERSAO_001);
$worker->run();
