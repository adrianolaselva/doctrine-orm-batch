<?php

namespace CIELO\v001;

use CIELO\Common\DirectoryCommon;
use CIELO\Constants\OpcaoExtrato;
use CIELO\Constants\TipoRegistro;
use CIELO\Factories\WorkerInterface;
use CIELO\Providers\DoctrineORMServiceProvider;
use CIELO\Providers\ServiceContainer;
use CIELO\v001\Entity\ARVDV;
use CIELO\v001\Entity\ARVRO;
use CIELO\v001\Entity\CV;
use CIELO\v001\Entity\Header;
use CIELO\v001\Entity\RO;
use CIELO\v001\Repository\ARVDVRepository;
use CIELO\v001\Repository\ARVRORepository;
use CIELO\v001\Repository\CVRepository;
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
     * @var CV
     */
    private $cv;

    /**
     * @var ARVDV
     */
    private $arvDv;

    /**
     * @var ARVRO
     */
    private $arvRo;

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
     * @var CVRepository
     */
    private $cvRepository;

    /**
     * @var ARVDVRepository
     */
    private $arvDvRepository;

    /**
     * @var ARVRORepository
     */
    private $arvRoRepository;

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
        $this->cv = new CV();
        $this->arvDv = new ARVDV();
        $this->arvRo = new ARVRO();

        $this->headerRepository = $this->em->getRepository(Header::class);
        $this->roRepository = $this->em->getRepository(RO::class);
        $this->cvRepository = $this->em->getRepository(CV::class);
        $this->arvDvRepository = $this->em->getRepository(ARVDV::class);
        $this->arvRoRepository = $this->em->getRepository(ARVRO::class);
    }

    /**
     * @throws Exception
     */
    public function run()
    {
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

        foreach ($rows as $row)
        {

            if(!is_numeric(substr($row, 0, 1)))
                continue;

            $tipoRegistro = substr($row, 0, 1);

            if($tipoRegistro == TipoRegistro::CIELO_HEADER)
            {
                $this->header->setDataInicio(new \DateTime('now'));
                $this->header->setLine($row, $fileName['hashFile']);
                $header = $this->headerRepository->exists($this->header);
                if(empty($header)){
                    $this->em->persist($this->header);
                    continue;
                }
                $this->header->setId($header->getId());
                $this->header = $this->em->merge($this->header);
            }

            switch($this->header->getOpcaoExtrato())
            {
                case OpcaoExtrato::CIELO_OPCAO_EXTRATO_VENDA_COM_CV_PARC_FUTURO:

                    switch($tipoRegistro)
                    {
                        case TipoRegistro::CIELO_RO:
                            $this->ro = new RO();
                            $this->ro->setLine($row, $this->header);
                            $ro = $this->roRepository->exists($this->ro);
                            if(empty($ro)){
                                $this->em->persist($this->ro);
                                continue;
                            }
                            $this->ro->setId($ro->getId());
                            $this->ro = $this->em->merge($this->ro);
                            break;
                        case TipoRegistro::CIELO_CV:
                            $this->cv = new CV();
                            $this->cv->setLine($row, $this->ro);
                            $cv = $this->cvRepository->exists($this->cv);
                            if(empty($cv)){
                                $this->em->persist($this->cv);
                                continue;
                            }
                            $this->cv->setId($cv->getId());
                            $this->cv = $this->em->merge($this->cv);
                            break;
                    }

                    break;
                case OpcaoExtrato::CIELO_OPCAO_EXTRATO_ANTECIPACAO_RECEBIVEIS:

                    switch($tipoRegistro)
                    {
                        case TipoRegistro::CIELO_ARV_DV:
                            $this->arvDv = new ARVDV();
                            $this->arvDv->setLine($row, $this->header);
                            $arvDv = $this->arvDvRepository->exists($this->arvDv);
                            if(empty($arvDv)){
                                $this->em->persist($this->arvDv);
                                continue;
                            }
                            $this->arvDv->setId($arvDv->getId());
                            $this->arvDv = $this->em->merge($this->arvDv);
                            break;
                        case TipoRegistro::CIELO_ARV_RO:
                            $this->arvRo = new ARVRO();
                            $this->arvRo->setLine($row, $this->arvDv);
                            $arvRo = $this->arvRoRepository->exists($this->arvRo);
                            if(empty($arvRo)){
                                $this->em->persist($this->arvRo);
                                continue;
                            }
                            $this->arvRo->setId($arvRo->getId());
                            $this->arvRo = $this->em->merge($this->arvRo);
                            break;
                        case TipoRegistro::CIELO_ARV_INF_ROS_ANTECIPADOS:
                            /**
                             * TODO: implementar importação
                             */
                            break;
                        case TipoRegistro::CIELO_ARV_INF_RO_SALDO_ABERTO:
                            /**
                             * TODO: implementar importação, mais antes identificar em qual tipo de arquivo este registro vem
                             */
                            break;
                        case TipoRegistro::CIELO_ARV_INF_POR_BANDEIRA_SALDO_ABERTO:
                            /**
                             * TODO: implementar importação, mais antes identificar em qual tipo de arquivo este registro vem
                             */
                            break;
                    }

                    break;
            }
        }

        $this->header->setDataFim(new \DateTime('now'));
        $this->em->merge($this->header);

        $this->em->flush();
        $this->em->clear();

        if(!rename(
            $fileName['fullName'], WorkerV001::PATH_BASE . getenv("test.edi.proccessed") . DIRECTORY_SEPARATOR
            . WorkerV001::DIRECTORY . DIRECTORY_SEPARATOR . $fileName['hashFile'])
        )
            throw new Exception("Falha ao mover arquivo, importação não efetivada");
    }
}