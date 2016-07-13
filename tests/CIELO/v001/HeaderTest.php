<?php

/**
 * Class HeaderTest
 */
class HeaderTest extends PHPUnit_Framework_TestCase
{
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

    const ID = 1;
    const HEADER = '010585494372016071120160711201607110006543CIELO03P                    001';
    const RO = '110585494375160710     01160710160809000000+0000000001100-0000000000065+0000000000000+0000000001035003303744000001300611990000000145000000 160710  0000000000000 000000000+0000000000000001161920310059864000000005900000000000241025843045';
    const CV = '210585494375160710506755******701200020160710+00000000011000000   395017                    25052400000000000001600000000000000000000000000000000000000041025843                      13374416192031005986400000000001000';

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     *
     */
    public function setUp()
    {
        $this->header = new \CIELO\v001\Entity\Header();
        $this->ro = new \CIELO\v001\Entity\RO();

        $this->container = new \CIELO\Providers\ServiceContainer();
        $this->container->register(new \CIELO\Providers\DoctrineORMServiceProvider());
        $this->em = $this->container['em'];
        parent::setUp();
    }

//    public function testBultInsert(){
//        $ponteiro = fopen(__DIR__ . DIRECTORY_SEPARATOR . '../../../var/edi-cielo/modelo_1.RET', 'r');
//        while(!feof($ponteiro)){
//            $linha = fgets($ponteiro, 4096);
//
//            switch(substr($linha, 0, 1)){
//                case '0':
//                    $this->header->setLine($linha);
//                    $this->em->persist($this->header);
//                    $this->ro->setHeader($this->header);
//                    break;
//                case '1':
//                    $this->ro->setLine($linha);
//                    $this->em->persist($this->ro);
//                    break;
//            }
//        }
//        fclose($ponteiro);
//
//        $this->em->flush();
//        $this->assertEquals(true, true);
//    }

    public function testSetline(){
        $header = new \CIELO\v001\Entity\Header();
        $ro = new \CIELO\v001\Entity\RO();

        $header->setLine(HeaderTest::HEADER);

        $this->em->persist($header);
        $ro->setLine(HeaderTest::RO);
        $ro->setHeader($header);

        $this->em->persist($ro);

        $this->em->flush();

        $this->assertEquals(true, true);
    }

    public function testCanLoadUser()
    {
        $this->assertEquals(true, true);
    }
}