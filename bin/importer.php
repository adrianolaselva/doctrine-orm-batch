<?php

require __DIR__ . DIRECTORY_SEPARATOR . '../bootstrap.php';

$worker = new \CIELO\Worker();
$worker->run();