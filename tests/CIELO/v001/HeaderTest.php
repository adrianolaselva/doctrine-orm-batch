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
        $this->worker = \CIELO\Factories\WorkerFactory::getInstance(\CIELO\Constants\Versao::CIELO_VERSAO_001);

        $this->header = new \CIELO\v001\Entity\Header();
        $this->ro = new \CIELO\v001\Entity\RO();

        $this->container = new \CIELO\Providers\ServiceContainer();
        $this->container->register(new \CIELO\Providers\DoctrineORMServiceProvider());
        $this->em = $this->container['em'];
        parent::setUp();
    }

    public function testVariaveisAmbienteForamCarregadas(){
        $this->assertNotFalse(getenv("test.edi.pending"));
        $this->assertNotFalse(getenv("test.edi.proccessed"));
    }

    public function testDiretoriosExistem(){
        $this->assertTrue(is_dir(HeaderTest::PATH_BASE . getenv("test.edi.pending")));
        $this->assertTrue(is_dir(HeaderTest::PATH_BASE . getenv("test.edi.proccessed")));
    }

    public function testWorker(){
        $this->worker->run();
    }

}