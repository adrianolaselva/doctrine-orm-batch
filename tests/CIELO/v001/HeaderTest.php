<?php

/**
 * Class HeaderTest
 */
class HeaderTest extends PHPUnit_Framework_TestCase
{
    const PATH_BASE = __DIR__ . DIRECTORY_SEPARATOR . '../../';

    const PATH_PENDING = __DIR__ . DIRECTORY_SEPARATOR . '../../var/mine/pending';
    const PATH_PROCCESSED = __DIR__ . DIRECTORY_SEPARATOR . '../../var/mine/proccessed';

    /**
     * @var \CIELO\Providers\ServiceContainer
     */
    private $container;

    /**
     * @var \CIELO\v001\Entity\Header
     */
    private $header;

    /**
     * @var \CIELO\v001\Entity\RO
     */
    private $ro;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var \CIELO\Factories\WorkerInterface
     */
    private $worker;

    /**
     *
     */
    public function setUp()
    {
        $params = parse_ini_file(__DIR__ . DIRECTORY_SEPARATOR . '../../../config.ini', true);

        if(is_null($params['EDI_DIRECTORIES_TESTS']))
            throw new \Exception("Diretórios não configurado no arquivo config.ini");

        foreach($params['EDI_DIRECTORIES_TESTS'] as $key => $value){
            putenv("{$key}={$value}");
        }

        $this->worker = \CIELO\Factories\WorkerFactory::getInstance(\CIELO\Constants\Versao::CIELO_VERSAO_001);

//        $this->header = new \CIELO\v001\Entity\Header();
//        $this->ro = new \CIELO\v001\Entity\RO();

//        $this->container = new \CIELO\Providers\ServiceContainer();
//        $this->container->register(new \CIELO\Providers\DoctrineORMServiceProvider());
//        $this->em = $this->container['em'];
        parent::setUp();
    }

    public function testVariaveisAmbienteForamCarregadas()
    {
        $this->assertNotFalse(getenv("test.edi.pending"));
        $this->assertNotFalse(getenv("test.edi.proccessed"));
    }

    public function testDiretoriosExistem()
    {
        $this->assertTrue(is_dir(HeaderTest::PATH_BASE . getenv("test.edi.pending")));
        $this->assertTrue(is_dir(HeaderTest::PATH_BASE . getenv("test.edi.proccessed")));
    }

    public function testWorkerExtratoAntRecebiveis()
    {
        $processed = HeaderTest::PATH_BASE . getenv("test.edi.proccessed") . DIRECTORY_SEPARATOR . 'cielo' . DIRECTORY_SEPARATOR . '3a2df08ce2e98441cad7b341efee2275d234adeb';
        $pending =  HeaderTest::PATH_BASE . getenv("test.edi.pending") . DIRECTORY_SEPARATOR . 'cielo' . DIRECTORY_SEPARATOR . '3a2df08ce2e98441cad7b341efee2275d234adeb';

        try{
            if(is_file($processed)){
                $this->assertTrue(rename($processed,$pending), "Falha ao mover o arquivo para pasta pending");
            }
            $this->worker->run();
            $this->assertTrue(true);
        }catch (Exception $ex){
            $this->assertTrue(false, $ex->getMessage());
        }
    }

    public function testWorkerCVParceladoFuturo()
    {
//        $processed = HeaderTest::PATH_BASE . getenv("test.edi.proccessed") . DIRECTORY_SEPARATOR . 'cielo' . DIRECTORY_SEPARATOR . '58c005fa1abffa8518c10770e6259f215b07ed8a';
//        $pending =  HeaderTest::PATH_BASE . getenv("test.edi.pending") . DIRECTORY_SEPARATOR . 'cielo' . DIRECTORY_SEPARATOR . '58c005fa1abffa8518c10770e6259f215b07ed8a';
//
//        try{
//            if(is_file($processed)){
//                $this->assertTrue(rename($processed,$pending), "Falha ao mover o arquivo para pasta pending");
//            }
//            $this->worker->run();
//            $this->assertTrue(true);
//        }catch (Exception $ex){
//            $this->assertTrue(false, $ex->getMessage());
//        }
    }

}