<?php

namespace CIELO\v001\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Header
 * @package CIELO\v001\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="header")
 * @ORM\HasLifecycleCallbacks()
 */
class Header
{
    /**
     * @var integer
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $estabelecimentoMatriz;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=false)
     */
    protected $dataProcessamento;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=false)
     */
    protected $periodoInicial;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=false)
     */
    protected $periodoFinal;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $sequencia;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $empresaAdquirente;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $opcaoExtrato;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $van;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $versaoLayout;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $usoCielo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $dataImportacao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $dataAtualizacao;

    /**
     * Header constructor.
     */
    public function __construct()
    {

    }

    /**
     * @ORM\PrePersist()
     */
    private function prePersist(){
        $this->dataImportacao = new \DateTime('now');
    }

    /**
     * @ORM\PreUpdate()
     */
    private function preUpdate(){
        $this->dataAtualizacao = new \DateTime('now');
    }

    /**
     * @return mixed
     */
    public function getDataProcessamento()
    {
        return $this->dataProcessamento;
    }

    /**
     * @param mixed $dataProcessamento
     * @return Header
     */
    public function setDataProcessamento($dataProcessamento)
    {
        $this->dataProcessamento = $dataProcessamento;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmpresaAdquirente()
    {
        return $this->empresaAdquirente;
    }

    /**
     * @param mixed $empresaAdquirente
     * @return Header
     */
    public function setEmpresaAdquirente($empresaAdquirente)
    {
        $this->empresaAdquirente = $empresaAdquirente;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEstabelecimentoMatriz()
    {
        return $this->estabelecimentoMatriz;
    }

    /**
     * @param mixed $estabelecimentoMatriz
     * @return Header
     */
    public function setEstabelecimentoMatriz($estabelecimentoMatriz)
    {
        $this->estabelecimentoMatriz = $estabelecimentoMatriz;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Header
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOpcaoExtrato()
    {
        return $this->opcaoExtrato;
    }

    /**
     * @param mixed $opcaoExtrato
     * @return Header
     */
    public function setOpcaoExtrato($opcaoExtrato)
    {
        $this->opcaoExtrato = $opcaoExtrato;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPeriodoFinal()
    {
        return $this->periodoFinal;
    }

    /**
     * @param mixed $periodoFinal
     * @return Header
     */
    public function setPeriodoFinal($periodoFinal)
    {
        $this->periodoFinal = $periodoFinal;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPeriodoInicial()
    {
        return $this->periodoInicial;
    }

    /**
     * @param mixed $periodoInicial
     * @return Header
     */
    public function setPeriodoInicial($periodoInicial)
    {
        $this->periodoInicial = $periodoInicial;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSequencia()
    {
        return $this->sequencia;
    }

    /**
     * @param mixed $sequencia
     * @return Header
     */
    public function setSequencia($sequencia)
    {
        $this->sequencia = $sequencia;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVan()
    {
        return $this->van;
    }

    /**
     * @param mixed $van
     * @return Header
     */
    public function setVan($van)
    {
        $this->van = $van;
        return $this;
    }

}