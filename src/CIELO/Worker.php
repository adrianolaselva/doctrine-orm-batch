<?php

namespace CIELO;

use CIELO\Common\DirectoryCommon;
use CIELO\Constants\AdquirenteDirectory;
use CIELO\Constants\Versao;
use CIELO\Factories\WorkerFactory;
use CIELO\Factories\WorkerInterface;
use Exception;

/**
 * Class Worker
 * @package CIELO
 */
class Worker
{
    /**
     * @var WorkerInterface
     */
    private $_worker;

    /**
     * Worker constructor.
     */
    public function __construct()
    {
    }

    /**
     * @throws Exception
     */
    public function run()
    {
        if(!is_dir(Worker::PATH_BASE . getenv("edi.pending")))
            throw new Exception("Pending directory não encontrado");

        if(!is_dir(Worker::PATH_BASE . getenv("edi.proccessed")))
            throw new Exception("Proccessed directory não encontrado");

        $directories = DirectoryCommon::dirEDIFilesToArray(
            Worker::PATH_BASE . getenv("edi.pending"),
            AdquirenteDirectory::CIELO);

        foreach($directories as $key => $fileName)
        {
            $file = file_get_contents($fileName['fullName'], 'r');
            $rows = explode(PHP_EOL, $file);

            if(!isset($rows[0]))
                continue;

            $versao = substr($rows[0], 70, 3);

            if(!in_array($versao,[Versao::CIELO_VERSAO_001]))
                continue;

            try{
                $this->_worker = WorkerFactory::getInstance($versao);
                $this->_worker->importer($fileName, $rows);
                $this->moveToProccessed($fileName);
            }catch (Exception $ex){

            }

        }

    }

    const PATH_BASE = __DIR__ . DIRECTORY_SEPARATOR . '../../';

    /**
     * @param $fileName
     * @throws Exception
     */
    private function moveToProccessed($fileName){
        if(!rename(
            $fileName['fullName'], Worker::PATH_BASE . getenv("edi.proccessed") . DIRECTORY_SEPARATOR
            . AdquirenteDirectory::CIELO . DIRECTORY_SEPARATOR . $fileName['hashFile'])
        )
            throw new Exception("Falha ao mover arquivo, importação não efetivada");
    }
}