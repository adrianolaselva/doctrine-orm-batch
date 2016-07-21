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
     * @var \Logger
     */
    private $_logger;

    /**
     * @var WorkerInterface
     */
    private $_worker;

    /**
     * Worker constructor.
     */
    public function __construct()
    {
        $this->_logger = \Logger::getLogger(__CLASS__);
    }

    /**
     * @throws Exception
     */
    public function run()
    {
        //$this->unblockAllFiles();exit();

        if(!is_dir(Worker::PATH_BASE . getenv("edi.pending")))
            throw new Exception("Pending directory não encontrado");

        if(!is_dir(Worker::PATH_BASE . getenv("edi.proccessed")))
            throw new Exception("Proccessed directory não encontrado");

        while(true)
        {
            try {
                $fileName = DirectoryCommon::getFileRand(
                    Worker::PATH_BASE . getenv("edi.pending"),
                    AdquirenteDirectory::CIELO);

                if (is_null($fileName))
                    break;

                if (!is_file($fileName['fullName']))
                    continue;

                $this->blockFile($fileName);
                $file = file_get_contents($fileName['fullName'] . '.wrk', 'r');

                $rows = explode(PHP_EOL, $file);
                $registros = count($rows);

                if (!isset($rows[0]))
                    continue;

                $versao = substr($rows[0], 70, 3);

                if (!in_array($versao, [
                        Versao::CIELO_VERSAO_001
                    ])
                ) continue;

                $tempoIni = microtime(true);
                $this->_logger->info("início importação de arquivo {$fileName['name']} registros:{$registros} v.{$versao} ");
                $this->_worker = WorkerFactory::getInstance($versao);
                $this->_worker->importer($fileName, $rows);
                $this->unblockFile($fileName);
                $this->moveToProccessed($fileName);
                $tempoTotal = microtime(true) - $tempoIni;
                $this->_logger->info("fim importação de arquivo {$fileName['name']} tempo:{$tempoTotal} ");
                printf("fim importação de arquivo {$fileName['name']} tempo:{$tempoTotal} " . PHP_EOL);
            }catch (Exception $ex){
                printf($ex->getMessage() . PHP_EOL);
                $this->_logger->error("Falha ao importar arquivo", $ex);
            }
        }
    }

    const PATH_BASE = __DIR__ . DIRECTORY_SEPARATOR . '../../';

    /**
     * @throws Exception
     */
    private function unblockAllFiles(){
        $directories = DirectoryCommon::dirEDIFilesAllToArray(
            Worker::PATH_BASE . getenv("edi.pending"),
            AdquirenteDirectory::CIELO);

        foreach ($directories as $key => $directory) {
            if(strpos(strtolower($directory['name']), ".wrk") !== false)
            {
                if(!rename($directory['fullName'], str_replace('.wrk','',$directory['fullName'])))
                    throw new Exception("Falha ao bloquear arquivo p/ importação");
            }
        }

    }

    /**
     * @param $fileName
     * @throws Exception
     */
    private function blockFile($fileName){
        if(is_file($fileName['fullName']))
            if(!rename($fileName['fullName'], $fileName['fullName'] . '.wrk'))
                throw new Exception("Falha ao bloquear arquivo p/ importação");
    }

    /**
     * @param $fileName
     * @throws Exception
     */
    private function unblockFile($fileName){
        if(is_file($fileName['fullName'] . '.wrk'))
            if(!rename($fileName['fullName'] . '.wrk', $fileName['fullName']))
                throw new Exception("Falha ao desbloquear arquivo");
    }

    /**
     * @param $fileName
     * @throws Exception
     */
    private function moveToProccessed($fileName){
        if(is_file($fileName['fullName']))
            if(!rename(
                $fileName['fullName'], Worker::PATH_BASE . getenv("edi.proccessed") . DIRECTORY_SEPARATOR
                . AdquirenteDirectory::CIELO . DIRECTORY_SEPARATOR . $fileName['hashFile'])
            )
                throw new Exception("Falha ao mover arquivo, importação não efetivada");
    }
}