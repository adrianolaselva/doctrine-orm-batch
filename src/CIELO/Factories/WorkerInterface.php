<?php

namespace CIELO\Factories;

/**
 * Interface IWorker
 * @package CIELO
 */
interface WorkerInterface
{
    public function importer($fileName, $rows);
}