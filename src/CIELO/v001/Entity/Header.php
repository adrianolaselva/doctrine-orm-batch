<?php

namespace CIELO\v001\Entity;

use CIELO\Constants\TipoRegistro;
use CIELO\Constants\Versao;
use CIELO\Helpers\DateTimeHelper;
use CIELO\Helpers\NumberHelper;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Exception;

/**
 * Class Header
 * @package CIELO\v001\Entity
 *
 * @ORM\Entity(repositoryClass="CIELO\v001\Repository\HeaderRepository")
 * @ORM\Table(name="v001_header")
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
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="CIELO\v001\Entity\RO",
     *     mappedBy="header",
     *     cascade={"persist", "remove", "merge"}, fetch="EXTRA_LAZY")
     */
    protected $ros;

    /**
     * @var string
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $tipoRegistro;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=30, nullable=false)
     */
    protected $estabelecimentoMatriz;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     */
    protected $dataProcessamento;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     */
    protected $periodoInicial;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     */
    protected $periodoFinal;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    protected $sequencia;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    protected $empresaAdquirente;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    protected $opcaoExtrato;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    protected $van;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    protected $caixaPostal;

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
     * @var string
     *
     * @ORM\Column(type="string", length=90,nullable=true)
     */
    protected $arquivo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $dataInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $dataFim;

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
        $this->ros = new ArrayCollection();
    }

    /**
     * @param $line
     * @return $this
     * @throws Exception
     */
    public function setLine($line, $fileName = null)
    {
        if(substr($line, 0, 1) != TipoRegistro::CIELO_HEADER)
            throw new Exception('Tipo registro inválido');

        if(substr($line, 70, 3) != Versao::CIELO_VERSAO_001)
            throw new Exception('Versão inválida');

        $this->tipoRegistro = NumberHelper::toInt(substr($line, 0, 1));
        $this->estabelecimentoMatriz = substr($line, 1, 10);
        $this->dataProcessamento = DateTimeHelper::formatFromToDateTime(substr($line, 11, 8),'Ymd');
        $this->periodoInicial = DateTimeHelper::formatFromToDateTime(substr($line, 19, 8),'Ymd');
        $this->periodoFinal = DateTimeHelper::formatFromToDateTime(substr($line, 27, 8),'Ymd');
        $this->sequencia = substr($line, 35, 7);
        $this->empresaAdquirente = substr($line, 42, 5);
        $this->opcaoExtrato = substr($line, 47, 2);
        $this->van = substr($line, 49, 1);
        $this->caixaPostal = substr($line, 50, 20);
        $this->versaoLayout = substr($line, 70, 3);
        $this->usoCielo = substr($line, 73, 177);
        $this->arquivo = $fileName;

        return $this;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist(){
        $this->dataImportacao = new \DateTime('now');
        $this->dataAtualizacao = new \DateTime('now');
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate(){
        $this->dataAtualizacao = new \DateTime('now');
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Header
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getRo()
    {
        return $this->ros;
    }

    /**
     * @param RO $ro
     * @return $this
     */
    public function addRo(RO $ro)
    {
        $this->ros->add($ro);
        return $this;
    }

    /**
     * @return string
     */
    public function getTipoRegistro()
    {
        return $this->tipoRegistro;
    }

    /**
     * @param string $tipoRegistro
     * @return Header
     */
    public function setTipoRegistro($tipoRegistro)
    {
        $this->tipoRegistro = $tipoRegistro;
        return $this;
    }

    /**
     * @return string
     */
    public function getEstabelecimentoMatriz()
    {
        return $this->estabelecimentoMatriz;
    }

    /**
     * @param string $estabelecimentoMatriz
     * @return Header
     */
    public function setEstabelecimentoMatriz($estabelecimentoMatriz)
    {
        $this->estabelecimentoMatriz = $estabelecimentoMatriz;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDataProcessamento()
    {
        return $this->dataProcessamento;
    }

    /**
     * @param \DateTime $dataProcessamento
     * @return Header
     */
    public function setDataProcessamento($dataProcessamento)
    {
        $this->dataProcessamento = $dataProcessamento;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPeriodoInicial()
    {
        return $this->periodoInicial;
    }

    /**
     * @param \DateTime $periodoInicial
     * @return Header
     */
    public function setPeriodoInicial($periodoInicial)
    {
        $this->periodoInicial = $periodoInicial;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPeriodoFinal()
    {
        return $this->periodoFinal;
    }

    /**
     * @param \DateTime $periodoFinal
     * @return Header
     */
    public function setPeriodoFinal($periodoFinal)
    {
        $this->periodoFinal = $periodoFinal;
        return $this;
    }

    /**
     * @return string
     */
    public function getSequencia()
    {
        return $this->sequencia;
    }

    /**
     * @param string $sequencia
     * @return Header
     */
    public function setSequencia($sequencia)
    {
        $this->sequencia = $sequencia;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmpresaAdquirente()
    {
        return $this->empresaAdquirente;
    }

    /**
     * @param string $empresaAdquirente
     * @return Header
     */
    public function setEmpresaAdquirente($empresaAdquirente)
    {
        $this->empresaAdquirente = $empresaAdquirente;
        return $this;
    }

    /**
     * @return string
     */
    public function getOpcaoExtrato()
    {
        return $this->opcaoExtrato;
    }

    /**
     * @param string $opcaoExtrato
     * @return Header
     */
    public function setOpcaoExtrato($opcaoExtrato)
    {
        $this->opcaoExtrato = $opcaoExtrato;
        return $this;
    }

    /**
     * @return string
     */
    public function getVan()
    {
        return $this->van;
    }

    /**
     * @param string $van
     * @return Header
     */
    public function setVan($van)
    {
        $this->van = $van;
        return $this;
    }

    /**
     * @return string
     */
    public function getCaixaPostal()
    {
        return $this->caixaPostal;
    }

    /**
     * @param string $caixaPostal
     * @return Header
     */
    public function setCaixaPostal($caixaPostal)
    {
        $this->caixaPostal = $caixaPostal;
        return $this;
    }

    /**
     * @return string
     */
    public function getVersaoLayout()
    {
        return $this->versaoLayout;
    }

    /**
     * @param string $versaoLayout
     * @return Header
     */
    public function setVersaoLayout($versaoLayout)
    {
        $this->versaoLayout = $versaoLayout;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsoCielo()
    {
        return $this->usoCielo;
    }

    /**
     * @param string $usoCielo
     * @return Header
     */
    public function setUsoCielo($usoCielo)
    {
        $this->usoCielo = $usoCielo;
        return $this;
    }

    /**
     * @return string
     */
    public function getArquivo()
    {
        return $this->arquivo;
    }

    /**
     * @param string $arquivo
     * @return Header
     */
    public function setArquivo($arquivo)
    {
        $this->arquivo = $arquivo;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDataImportacao()
    {
        return $this->dataImportacao;
    }

    /**
     * @param \DateTime $dataImportacao
     * @return Header
     */
    public function setDataImportacao($dataImportacao)
    {
        $this->dataImportacao = $dataImportacao;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDataAtualizacao()
    {
        return $this->dataAtualizacao;
    }

    /**
     * @param \DateTime $dataAtualizacao
     * @return Header
     */
    public function setDataAtualizacao($dataAtualizacao)
    {
        $this->dataAtualizacao = $dataAtualizacao;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDataFim()
    {
        return $this->dataFim;
    }

    /**
     * @param \DateTime $dataFim
     * @return Header
     */
    public function setDataFim($dataFim)
    {
        $this->dataFim = $dataFim;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDataInicio()
    {
        return $this->dataInicio;
    }

    /**
     * @param \DateTime $dataInicio
     * @return Header
     */
    public function setDataInicio($dataInicio)
    {
        $this->dataInicio = $dataInicio;
        return $this;
    }

    /**
     * @param ArrayCollection $ros
     * @return Header
     */
    public function setRos($ros)
    {
        $this->ros = $ros;
        return $this;
    }

}