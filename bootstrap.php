<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$container = new \Pimple\Container();
$container->register(new \CIELO\Providers\DoctrineORMServiceProvider());

$em = $container['em'];

//carrega configurações
//$config = parse_ini_file(
//    __DIR__ . DIRECTORY_SEPARATOR . 'config.ini'
//);

