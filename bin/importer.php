<?php

require __DIR__ . DIRECTORY_SEPARATOR . '../bootstrap.php';

$worker = \CIELO\Factories\WorkerFactory::getInstance(\CIELO\Constants\Versao::CIELO_VERSAO_001);
$worker->run();