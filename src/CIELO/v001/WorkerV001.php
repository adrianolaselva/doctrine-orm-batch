<?php

namespace CIELO\v001;

use CIELO\Constants\OpcaoExtrato;
use CIELO\Constants\TipoRegistro;
use CIELO\Factories\WorkerInterface;
use CIELO\Providers\ServiceContainer;
use CIELO\v001\Entity\ARVDV;
use CIELO\v001\Entity\ARVRO;
use CIELO\v001\Entity\ARVRODebito;
use CIELO\v001\Entity\CV;
use CIELO\v001\Entity\Header;
use CIELO\v001\Entity\RO;
use CIELO\v001\Repository\ARVDVRepository;
use CIELO\v001\Repository\ARVRORepository;
use CIELO\v001\Repository\CVRepository;
use CIELO\v001\Repository\HeaderRepository;
use CIELO\v001\Repository\RORepository;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityManager;
use Exception;

/**
 * Class WorkerV001
 * @package CIELO\v001
 */
class WorkerV001 implements WorkerInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

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
     * @var ARVRODebito
     */
    private $arvRoDebito;

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
     * @var ARVRORepository
     */
    private $arvRoDebitoRepository;

    /**
     * WorkerV001 constructor.
     */
    public function __construct($em)
    {
        $this->em = $em;

        $this->headerRepository = $this->em->getRepository(Header::class);
        $this->roRepository = $this->em->getRepository(RO::class);
        $this->cvRepository = $this->em->getRepository(CV::class);
        $this->arvDvRepository = $this->em->getRepository(ARVDV::class);
        $this->arvRoRepository = $this->em->getRepository(ARVRO::class);
        $this->arvRoDebitoRepository = $this->em->getRepository(ARVRODebito::class);

        $this->header = new Header();
        $this->ro = new RO();
        $this->cv = new CV();
        $this->arvDv = new ARVDV();
        $this->arvRo = new ARVRO();
    }

    /**
     * @param $fileName
     * @param $rows
     * @throws Exception
     */
    public function importer($fileName, $rows)
    {
        $batchSize = 10;
        try{
            $this->em->getConnection()->beginTransaction();
            foreach ($rows as $key => $row)
            {

                if(!is_numeric(substr($row, 0, 1)))
                    continue;

                $tipoRegistro = substr($row, 0, 1);

                if($tipoRegistro == TipoRegistro::CIELO_HEADER)
                {
                    $this->header->setLinhas(count($rows));
                    $this->header->setLine($row, $fileName['hashFile']);
                    $header = null;//$this->headerRepository->exists($this->header);
                    if(empty($header)){
                        $this->em->persist($this->header);
                        continue;
                    }
//                    $this->header = $header;
//                    $this->header->setLine($row, $fileName['hashFile']);
//                    $this->header = $this->em->merge($this->header);
                }

                switch($this->header->getOpcaoExtrato())
                {
                    case OpcaoExtrato::CIELO_OPCAO_EXTRATO_VENDA_COM_CV_PARC_FUTURO:

                        switch($tipoRegistro)
                        {
                            case TipoRegistro::CIELO_RO:
                                $this->ro = new RO();
                                $this->ro->setLine($row, $this->header);
                                $ro = null;//$this->roRepository->exists($this->ro);
                                if(empty($ro)){
                                    $this->em->persist($this->ro);
                                    continue;
                                }
//                                $this->ro->setId($ro->getId());
//                                $this->ro = $this->em->merge($this->ro);
                                break;
                            case TipoRegistro::CIELO_CV:
                                $this->cv = new CV();
                                $this->cv->setLine($row, $this->ro);
                                $cv = null;//$this->cvRepository->exists($this->cv);
                                if(empty($cv)){
                                    $this->em->persist($this->cv);
                                    continue;
                                }
//                                $this->cv->setId($cv->getId());
//                                $this->cv = $this->em->merge($this->cv);
                                break;
                        }

                        break;
                    case OpcaoExtrato::CIELO_OPCAO_EXTRATO_ANTECIPACAO_RECEBIVEIS:

                        switch($tipoRegistro)
                        {
                            case TipoRegistro::CIELO_ARV_DV:
                                $this->arvDv = new ARVDV();
                                $this->arvDv->setLine($row, $this->header);
                                $arvDv = null;//$this->arvDvRepository->exists($this->arvDv);
                                if(empty($arvDv)){
                                    $this->em->persist($this->arvDv);
                                    continue;
                                }
//                                $this->arvDv->setId($arvDv->getId());
//                                $this->arvDv = $this->em->merge($this->arvDv);
                                break;
                            case TipoRegistro::CIELO_ARV_RO:
                                $this->arvRo = new ARVRO();
                                $this->arvRo->setLine($row, $this->arvDv);
                                $arvRo = null;//$this->arvRoRepository->exists($this->arvRo);
                                if(empty($arvRo)){
                                    $this->em->persist($this->arvRo);
                                    continue;
                                }
//                                $this->arvRo->setId($arvRo->getId());
//                                $this->arvRo = $this->em->merge($this->arvRo);
                                break;
                            case TipoRegistro::CIELO_ARV_INF_ROS_ANTECIPADOS:
                                $this->arvRoDebito = new ARVRODebito();
                                $this->arvRoDebito->setLine($row, $this->arvDv);
                                $arvRoDebito = null;//$this->arvRoDebitoRepository->exists($this->arvRoDebito);
                                if(empty($arvRoDebito)){
                                    $this->em->persist($this->arvRoDebito);
                                    continue;
                                }
//                                $this->arvRoDebito->setId($arvRoDebito->getId());
//                                $this->arvRoDebito = $this->em->merge($this->arvRoDebito);
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

//                if(($key % $batchSize) == 0)
//                {
//                    $this->em->flush();
//                    $this->em->clear();
//                }

            }

            $this->em->flush();
            $this->em->clear();

            $this->em->getConnection()->commit();
        }catch (Exception $ex){
            $this->em->getConnection()->rollBack();
            throw new Exception($ex->getMessage());
        }

    }

}