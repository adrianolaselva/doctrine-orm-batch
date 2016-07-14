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

    public function testWorker(){
        $this->worker->run();
    }

    public function testVariaveisAmbienteForamCarregadas(){
        $this->assertNotFalse(getenv("test.edi.pending"));
        $this->assertNotFalse(getenv("test.edi.proccessed"));
    }

    public function testDiretoriosExistem(){
        $this->assertTrue(is_dir(HeaderTest::PATH_BASE . getenv("test.edi.pending")));
        $this->assertTrue(is_dir(HeaderTest::PATH_BASE . getenv("test.edi.proccessed")));
    }

//    public function testBultInsert()
//    {
//        $headerRepository = $this->em->getRepository(\CIELO\v001\Entity\Header::class);
//        $roRepository = $this->em->getRepository(\CIELO\v001\Entity\RO::class);
//
//        $directories = \CIELO\Common\DirectoryCommon::dirEDIFilesToArray(
//            HeaderTest::PATH_BASE . getenv("test.edi.pending"),
//            \CIELO\Common\DirectoryCommon::DIRECTORY_EDI_CIELO);
//
//        foreach($directories as $key => $fileName)
//        {
//            $file = file_get_contents($fileName['fullName'], 'r');
//            $rows = explode(PHP_EOL, $file);
//
//            foreach ($rows as $row) {
//
//                if(!is_numeric(substr($row, 0, 1)))
//                    continue;
//
//                switch(substr($row, 0, 1)){
//                    case '0':
//                        $this->header = new \CIELO\v001\Entity\Header();
//                        $this->header->setLine($row, $fileName['hashFile']);
//
//                        $header = $headerRepository->exists($this->header);
//                        if(empty($header)){
//                            $this->em->persist($this->header);
//                            continue;
//                        }
//                        $this->header->setId($header->getId());
//                        $this->em->merge($this->header);
//                        break;
//                    case '1':
//                        $this->ro = new \CIELO\v001\Entity\RO();
//                        $this->ro->setLine($row, $this->header);
//
//                        $ro = $roRepository->exists($this->ro);
//                        if(empty($ro)){
//                            $this->em->persist($this->ro);
//                            continue;
//                        }
//                        $this->ro->setId($ro->getId());
//                        $this->em->merge($this->ro);
//                        break;
//                }
//            }
//
//            $this->em->flush();
//        }
//
//        $this->assertEquals(true, true);
//    }

}