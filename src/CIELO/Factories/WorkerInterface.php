<?php

namespace CIELO\Factories;

/**
 * Interface WorkerInterface
 * @package CIELO\Factories
 */
interface WorkerInterface
{
    public function importer($fileName, $rows);
}