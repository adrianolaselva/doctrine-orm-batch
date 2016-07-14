<?php

namespace CIELO\v001;

use CIELO\Common\DirectoryCommon;
use CIELO\Factories\WorkerInterface;
use CIELO\Providers\DoctrineORMServiceProvider;
use CIELO\Providers\ServiceContainer;
use CIELO\v001\Entity\Header;
use CIELO\v001\Entity\RO;
use CIELO\v001\Repository\HeaderRepository;
use CIELO\v001\Repository\RORepository;
use Exception;

/**
 * Class WorkerV001
 * @package CIELO\v001
 */
class WorkerV001 implements WorkerInterface
{

    const PATH_BASE = __DIR__ . DIRECTORY_SEPARATOR . '../../../tests/';

    const DIRECTORY = 'cielo';

    /**
     * @var ServiceContainer
     */
    private $container;

    /**
     * @var Header
     */
    private $header;

    /**
     * @var RO
     */
    private $ro;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var HeaderRepository
     */
    private $headerRepository;

    /**
     * @var RORepository
     */
    private $roRepository;

    /**
     * WorkerV001 constructor.
     */
    public function __construct()
    {
        $this->container = new ServiceContainer();
        $this->container->register(new DoctrineORMServiceProvider());
        $this->em = $this->container['em'];

        $this->header = new Header();
        $this->ro = new RO();

        $this->headerRepository = $this->em->getRepository(Header::class);
        $this->roRepository = $this->em->getRepository(RO::class);
    }

    /**
     * @throws Exception
     */
    public function run()
    {
        var_dump(__DIR__);
        if(!is_dir(WorkerV001::PATH_BASE . getenv("test.edi.pending")))
            throw new Exception("Pending directory não encontrado");

        if(!is_dir(WorkerV001::PATH_BASE . getenv("test.edi.proccessed")))
            throw new Exception("Proccessed directory não encontrado");

        $directories = DirectoryCommon::dirEDIFilesToArray(
            WorkerV001::PATH_BASE . getenv("test.edi.pending"),
            WorkerV001::DIRECTORY);

        try{
            $this->em->beginTransaction();
            foreach($directories as $key => $fileName)
            {
                $this->importer($fileName);
            }
            $this->em->commit();
        }catch(Exception $ex){
            $this->em->rollback();
        }

    }

    private function importer($fileName)
    {
        $file = file_get_contents($fileName['fullName'], 'r');
        $rows = explode(PHP_EOL, $file);

        foreach ($rows as $row) {

            if(!is_numeric(substr($row, 0, 1)))
                continue;

            switch(substr($row, 0, 1)){
                case '0':
                    $this->header = new Header();
                    $this->header->setLine($row, $fileName['hashFile']);
                    $header = $this->headerRepository->exists($this->header);
                    if(empty($header)){
                        $this->em->persist($this->header);
                        continue;
                    }
                    $this->header->setId($header->getId());
                    $this->em->merge($this->header);
                    break;
                case '1':
                    $this->ro = new RO();
                    $this->ro->setLine($row, $this->header);
                    $ro = $this->roRepository->exists($this->ro);
                    if(empty($ro)){
                        $this->em->persist($this->ro);
                        continue;
                    }
                    $this->ro->setId($ro->getId());
                    $this->em->merge($this->ro);
                    break;
            }
        }
        $this->em->flush();

        if(!rename(
            $fileName['fullName'],
            WorkerV001::PATH_BASE
            . getenv("test.edi.proccessed")
            . DIRECTORY_SEPARATOR
            . WorkerV001::DIRECTORY
            . DIRECTORY_SEPARATOR
            . $fileName['hashFile']))
            throw new Exception("Falha ao mover arquivo, importação não efetivada");
    }
}