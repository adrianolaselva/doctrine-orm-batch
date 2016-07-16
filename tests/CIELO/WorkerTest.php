<?php

/**
 * Class WorkerTest
 */
class WorkerTest extends PHPUnit_Framework_TestCase
{
    const PATH_BASE = __DIR__ . DIRECTORY_SEPARATOR . '../../';

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

        parent::setUp();
    }

    public function testVariaveisAmbienteForamCarregadas()
    {
        $this->assertNotFalse(getenv("edi.pending"));
        $this->assertNotFalse(getenv("edi.proccessed"));
    }

    public function testDiretoriosExistem()
    {
        $this->assertTrue(is_dir(WorkerTest::PATH_BASE . getenv("edi.pending")));
        $this->assertTrue(is_dir(WorkerTest::PATH_BASE . getenv("edi.proccessed")));
    }

    public function testWorkerExtratoAntRecebiveis()
    {
        $processed = WorkerTest::PATH_BASE . getenv("edi.proccessed") . DIRECTORY_SEPARATOR . 'cielo' . DIRECTORY_SEPARATOR . '3a2df08ce2e98441cad7b341efee2275d234adeb';
        $pending =  WorkerTest::PATH_BASE . getenv("edi.pending") . DIRECTORY_SEPARATOR . 'cielo' . DIRECTORY_SEPARATOR . '3a2df08ce2e98441cad7b341efee2275d234adeb';

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
        $processed = WorkerTest::PATH_BASE . getenv("edi.proccessed") . DIRECTORY_SEPARATOR . 'cielo' . DIRECTORY_SEPARATOR . '58c005fa1abffa8518c10770e6259f215b07ed8a';
        $pending =  WorkerTest::PATH_BASE . getenv("edi.pending") . DIRECTORY_SEPARATOR . 'cielo' . DIRECTORY_SEPARATOR . '58c005fa1abffa8518c10770e6259f215b07ed8a';

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

    public function testWorkerCVParceladoFuturo2()
    {
        $processed = WorkerTest::PATH_BASE . getenv("edi.proccessed") . DIRECTORY_SEPARATOR . 'cielo' . DIRECTORY_SEPARATOR . 'fae9ecf9f4afe446c745613bec59a022e03a4fb9';
        $pending =  WorkerTest::PATH_BASE . getenv("edi.pending") . DIRECTORY_SEPARATOR . 'cielo' . DIRECTORY_SEPARATOR . 'fae9ecf9f4afe446c745613bec59a022e03a4fb9';

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

}