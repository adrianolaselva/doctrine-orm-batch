<?php

namespace CIELO\v001\Entity;

use CIELO\Constants\TipoRegistro;
use CIELO\Helpers\DateTimeHelper;
use CIELO\Helpers\NumberHelper;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Exception;

/**
 * Class RO
 * @package CIELO\v001\Entity
 *
 * @ORM\Entity(repositoryClass="CIELO\v001\Repository\ARVDVRepository")
 * @ORM\Table(name="v001_arvdv")
 */
class ARVDV
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
     * @var Header
     *
     * @ORM\ManyToOne(targetEntity="CIELO\v001\Entity\Header", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="id_header", referencedColumnName="id", nullable=false)
     */
    protected $header;

    /**
     * @var string
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $tipoRegistro;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $estabelecimentoSubmissao;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $numeroOperacaoFinanceira;

    /**
     * @var string
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $dataCreditoOperacao;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $sinalBrutoValorAntecipacaoAVista;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", nullable=true, precision=12, scale=2)
     */
    protected $valorBrutoAntecipacaoAVista;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $sinalAntecipacaoValorBrutoParcelado;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", nullable=true, precision=12, scale=2)
     */
    protected $valorBrutoAntecipacaoParcelado;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $sinalValorBrutoAntecipacaoEletronPreDatado;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", nullable=true, precision=12, scale=2)
     */
    protected $valorBrutoAntecipacaoEletronPreDatado;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $sinalValorBrutoAntecipacaoTotal;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", nullable=true, precision=12, scale=2)
     */
    protected $valorBrutoAntecipacaoTotal;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $sinalValorLiquidoAntecipacaoAVista;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", nullable=true, precision=12, scale=2)
     */
    protected $valorLiquidoAntecipacaoAVista;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $sinalValorLiquidoAntecipacaoParcelado;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", nullable=true, precision=12, scale=2)
     */
    protected $valorLiquidoAntecipacaoParcelado;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $sinalValorLiquivoAntecipacaoPreDatado;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", nullable=true, precision=12, scale=2)
     */
    protected $valorLiquidoAntecipacaoPreDatado;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $sinalValorLiquidoAntecipacaoTotal;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", nullable=true, precision=12, scale=2)
     */
    protected $valorLiquidoAntecipacaoTotal;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true, precision=3, scale=3)
     */
    protected $taxaDescontoAntecipacao;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $codigoBancoDomicilio;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $codigoAgenciaDomicilio;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $codigoContaCorrenteDomicilio;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $sinalValorLiquidoAntecipacao;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", nullable=true, precision=12, scale=2)
     */
    protected $valorLiquidoAntecipacao;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $usoCielo;

    /**
     * ARVDV constructor.
     */
    public function __construct()
    {
        $this->arvRos = new ArrayCollection();
    }

    /**
     * @param $line
     * @param Header $header
     * @return $this
     * @throws Exception
     */
    public function setLine($line, $header = null)
    {
        if(substr($line, 0, 1) != TipoRegistro::CIELO_ARV_DV)
            throw new Exception('Tipo registro inválido');

        if($header instanceof Header)
            $this->header = $header;

        $this->tipoRegistro = substr($line, 0,1);
        $this->estabelecimentoSubmissao = substr($line, 1,10);
        $this->numeroOperacaoFinanceira = substr($line, 10,9);
        $this->dataCreditoOperacao = DateTimeHelper::formatFromToDateTime(substr($line, 20,8), 'Ymd');
        $this->sinalBrutoValorAntecipacaoAVista = substr($line, 28,1);
        $this->valorBrutoAntecipacaoAVista = NumberHelper::formatDecimalDiv(substr($line, 29,13));
        $this->sinalAntecipacaoValorBrutoParcelado = substr($line, 42,1);
        $this->valorBrutoAntecipacaoParcelado = NumberHelper::formatDecimalDiv(substr($line, 43,13));
        $this->sinalValorBrutoAntecipacaoEletronPreDatado = substr($line, 56,1);
        $this->valorBrutoAntecipacaoEletronPreDatado = NumberHelper::formatDecimalDiv(substr($line, 57,13));
        $this->sinalValorBrutoAntecipacaoTotal = substr($line, 70,1);
        $this->valorBrutoAntecipacaoTotal = NumberHelper::formatDecimalDiv(substr($line, 71,13));
        $this->sinalValorLiquidoAntecipacaoAVista = substr($line, 84,1);
        $this->valorLiquidoAntecipacaoAVista = NumberHelper::formatDecimalDiv(substr($line, 85,13));
        $this->sinalValorLiquidoAntecipacaoParcelado = substr($line, 98,1);
        $this->valorLiquidoAntecipacaoParcelado = NumberHelper::formatDecimalDiv(substr($line, 99,13));
        $this->sinalValorLiquivoAntecipacaoPreDatado = substr($line, 112,1);
        $this->valorLiquidoAntecipacaoPreDatado = NumberHelper::formatDecimalDiv(substr($line, 113,13));
        $this->sinalValorLiquidoAntecipacaoTotal = substr($line, 126,1);
        $this->valorLiquidoAntecipacaoTotal = NumberHelper::formatDecimalDiv(substr($line, 127,13));
        $this->taxaDescontoAntecipacao = NumberHelper::formatDecimalDiv(substr($line, 140,5),3);
        $this->codigoBancoDomicilio = substr($line, 145,4);
        $this->codigoAgenciaDomicilio = substr($line, 149,5);
        $this->codigoContaCorrenteDomicilio = substr($line, 154,14);
        $this->sinalValorLiquidoAntecipacao = substr($line, 168,1);
        $this->valorLiquidoAntecipacao = NumberHelper::formatDecimalDiv(substr($line, 169,13));
        $this->usoCielo = substr($line, 182,68);

        return $this;
    }

    /**
     * @return string
     */
    public function getCodigoAgenciaDomicilio()
    {
        return $this->codigoAgenciaDomicilio;
    }

    /**
     * @param string $codigoAgenciaDomicilio
     * @return ARVDV
     */
    public function setCodigoAgenciaDomicilio($codigoAgenciaDomicilio)
    {
        $this->codigoAgenciaDomicilio = $codigoAgenciaDomicilio;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodigoBancoDomicilio()
    {
        return $this->codigoBancoDomicilio;
    }

    /**
     * @param string $codigoBancoDomicilio
     * @return ARVDV
     */
    public function setCodigoBancoDomicilio($codigoBancoDomicilio)
    {
        $this->codigoBancoDomicilio = $codigoBancoDomicilio;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodigoContaCorrenteDomicilio()
    {
        return $this->codigoContaCorrenteDomicilio;
    }

    /**
     * @param string $codigoContaCorrenteDomicilio
     * @return ARVDV
     */
    public function setCodigoContaCorrenteDomicilio($codigoContaCorrenteDomicilio)
    {
        $this->codigoContaCorrenteDomicilio = $codigoContaCorrenteDomicilio;
        return $this;
    }

    /**
     * @return string
     */
    public function getDataCreditoOperacao()
    {
        return $this->dataCreditoOperacao;
    }

    /**
     * @param string $dataCreditoOperacao
     * @return ARVDV
     */
    public function setDataCreditoOperacao($dataCreditoOperacao)
    {
        $this->dataCreditoOperacao = $dataCreditoOperacao;
        return $this;
    }

    /**
     * @return string
     */
    public function getEstabelecimentoSubmissao()
    {
        return $this->estabelecimentoSubmissao;
    }

    /**
     * @param string $estabelecimentoSubmissao
     * @return ARVDV
     */
    public function setEstabelecimentoSubmissao($estabelecimentoSubmissao)
    {
        $this->estabelecimentoSubmissao = $estabelecimentoSubmissao;
        return $this;
    }

    /**
     * @return Header
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @param Header $header
     * @return ARVDV
     */
    public function setHeader($header)
    {
        $this->header = $header;
        return $this;
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
     * @return ARVDV
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumeroOperacaoFinanceira()
    {
        return $this->numeroOperacaoFinanceira;
    }

    /**
     * @param string $numeroOperacaoFinanceira
     * @return ARVDV
     */
    public function setNumeroOperacaoFinanceira($numeroOperacaoFinanceira)
    {
        $this->numeroOperacaoFinanceira = $numeroOperacaoFinanceira;
        return $this;
    }

    /**
     * @return string
     */
    public function getSinalAntecipacaoValorBrutoParcelado()
    {
        return $this->sinalAntecipacaoValorBrutoParcelado;
    }

    /**
     * @param string $sinalAntecipacaoValorBrutoParcelado
     * @return ARVDV
     */
    public function setSinalAntecipacaoValorBrutoParcelado($sinalAntecipacaoValorBrutoParcelado)
    {
        $this->sinalAntecipacaoValorBrutoParcelado = $sinalAntecipacaoValorBrutoParcelado;
        return $this;
    }

    /**
     * @return string
     */
    public function getSinalBrutoValorAntecipacaoAVista()
    {
        return $this->sinalBrutoValorAntecipacaoAVista;
    }

    /**
     * @param string $sinalBrutoValorAntecipacaoAVista
     * @return ARVDV
     */
    public function setSinalBrutoValorAntecipacaoAVista($sinalBrutoValorAntecipacaoAVista)
    {
        $this->sinalBrutoValorAntecipacaoAVista = $sinalBrutoValorAntecipacaoAVista;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSinalValorBrutoAntecipacaoEletronPreDatado()
    {
        return $this->sinalValorBrutoAntecipacaoEletronPreDatado;
    }

    /**
     * @param mixed $sinalValorBrutoAntecipacaoEletronPreDatado
     * @return ARVDV
     */
    public function setSinalValorBrutoAntecipacaoEletronPreDatado($sinalValorBrutoAntecipacaoEletronPreDatado)
    {
        $this->sinalValorBrutoAntecipacaoEletronPreDatado = $sinalValorBrutoAntecipacaoEletronPreDatado;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSinalValorBrutoAntecipacaoTotal()
    {
        return $this->sinalValorBrutoAntecipacaoTotal;
    }

    /**
     * @param mixed $sinalValorBrutoAntecipacaoTotal
     * @return ARVDV
     */
    public function setSinalValorBrutoAntecipacaoTotal($sinalValorBrutoAntecipacaoTotal)
    {
        $this->sinalValorBrutoAntecipacaoTotal = $sinalValorBrutoAntecipacaoTotal;
        return $this;
    }

    /**
     * @return string
     */
    public function getSinalValorLiquidoAntecipacao()
    {
        return $this->sinalValorLiquidoAntecipacao;
    }

    /**
     * @param string $sinalValorLiquidoAntecipacao
     * @return ARVDV
     */
    public function setSinalValorLiquidoAntecipacao($sinalValorLiquidoAntecipacao)
    {
        $this->sinalValorLiquidoAntecipacao = $sinalValorLiquidoAntecipacao;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSinalValorLiquidoAntecipacaoAVista()
    {
        return $this->sinalValorLiquidoAntecipacaoAVista;
    }

    /**
     * @param mixed $sinalValorLiquidoAntecipacaoAVista
     * @return ARVDV
     */
    public function setSinalValorLiquidoAntecipacaoAVista($sinalValorLiquidoAntecipacaoAVista)
    {
        $this->sinalValorLiquidoAntecipacaoAVista = $sinalValorLiquidoAntecipacaoAVista;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSinalValorLiquidoAntecipacaoParcelado()
    {
        return $this->sinalValorLiquidoAntecipacaoParcelado;
    }

    /**
     * @param mixed $sinalValorLiquidoAntecipacaoParcelado
     * @return ARVDV
     */
    public function setSinalValorLiquidoAntecipacaoParcelado($sinalValorLiquidoAntecipacaoParcelado)
    {
        $this->sinalValorLiquidoAntecipacaoParcelado = $sinalValorLiquidoAntecipacaoParcelado;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSinalValorLiquidoAntecipacaoTotal()
    {
        return $this->sinalValorLiquidoAntecipacaoTotal;
    }

    /**
     * @param mixed $sinalValorLiquidoAntecipacaoTotal
     * @return ARVDV
     */
    public function setSinalValorLiquidoAntecipacaoTotal($sinalValorLiquidoAntecipacaoTotal)
    {
        $this->sinalValorLiquidoAntecipacaoTotal = $sinalValorLiquidoAntecipacaoTotal;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSinalValorLiquivoAntecipacaoPreDatado()
    {
        return $this->sinalValorLiquivoAntecipacaoPreDatado;
    }

    /**
     * @param mixed $sinalValorLiquivoAntecipacaoPreDatado
     * @return ARVDV
     */
    public function setSinalValorLiquivoAntecipacaoPreDatado($sinalValorLiquivoAntecipacaoPreDatado)
    {
        $this->sinalValorLiquivoAntecipacaoPreDatado = $sinalValorLiquivoAntecipacaoPreDatado;
        return $this;
    }

    /**
     * @return float
     */
    public function getTaxaDescontoAntecipacao()
    {
        return $this->taxaDescontoAntecipacao;
    }

    /**
     * @param float $taxaDescontoAntecipacao
     * @return ARVDV
     */
    public function setTaxaDescontoAntecipacao($taxaDescontoAntecipacao)
    {
        $this->taxaDescontoAntecipacao = $taxaDescontoAntecipacao;
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
     * @return ARVDV
     */
    public function setUsoCielo($usoCielo)
    {
        $this->usoCielo = $usoCielo;
        return $this;
    }

    /**
     * @return float
     */
    public function getValorBrutoAntecipacaoAVista()
    {
        return $this->valorBrutoAntecipacaoAVista;
    }

    /**
     * @param float $valorBrutoAntecipacaoAVista
     * @return ARVDV
     */
    public function setValorBrutoAntecipacaoAVista($valorBrutoAntecipacaoAVista)
    {
        $this->valorBrutoAntecipacaoAVista = $valorBrutoAntecipacaoAVista;
        return $this;
    }

    /**
     * @return float
     */
    public function getValorBrutoAntecipacaoEletronPreDatado()
    {
        return $this->valorBrutoAntecipacaoEletronPreDatado;
    }

    /**
     * @param float $valorBrutoAntecipacaoEletronPreDatado
     * @return ARVDV
     */
    public function setValorBrutoAntecipacaoEletronPreDatado($valorBrutoAntecipacaoEletronPreDatado)
    {
        $this->valorBrutoAntecipacaoEletronPreDatado = $valorBrutoAntecipacaoEletronPreDatado;
        return $this;
    }

    /**
     * @return float
     */
    public function getValorBrutoAntecipacaoParcelado()
    {
        return $this->valorBrutoAntecipacaoParcelado;
    }

    /**
     * @param float $valorBrutoAntecipacaoParcelado
     * @return ARVDV
     */
    public function setValorBrutoAntecipacaoParcelado($valorBrutoAntecipacaoParcelado)
    {
        $this->valorBrutoAntecipacaoParcelado = $valorBrutoAntecipacaoParcelado;
        return $this;
    }

    /**
     * @return float
     */
    public function getValorBrutoAntecipacaoTotal()
    {
        return $this->valorBrutoAntecipacaoTotal;
    }

    /**
     * @param float $valorBrutoAntecipacaoTotal
     * @return ARVDV
     */
    public function setValorBrutoAntecipacaoTotal($valorBrutoAntecipacaoTotal)
    {
        $this->valorBrutoAntecipacaoTotal = $valorBrutoAntecipacaoTotal;
        return $this;
    }

    /**
     * @return float
     */
    public function getValorLiquidoAntecipacao()
    {
        return $this->valorLiquidoAntecipacao;
    }

    /**
     * @param float $valorLiquidoAntecipacao
     * @return ARVDV
     */
    public function setValorLiquidoAntecipacao($valorLiquidoAntecipacao)
    {
        $this->valorLiquidoAntecipacao = $valorLiquidoAntecipacao;
        return $this;
    }

    /**
     * @return float
     */
    public function getValorLiquidoAntecipacaoAVista()
    {
        return $this->valorLiquidoAntecipacaoAVista;
    }

    /**
     * @param float $valorLiquidoAntecipacaoAVista
     * @return ARVDV
     */
    public function setValorLiquidoAntecipacaoAVista($valorLiquidoAntecipacaoAVista)
    {
        $this->valorLiquidoAntecipacaoAVista = $valorLiquidoAntecipacaoAVista;
        return $this;
    }

    /**
     * @return float
     */
    public function getValorLiquidoAntecipacaoParcelado()
    {
        return $this->valorLiquidoAntecipacaoParcelado;
    }

    /**
     * @param float $valorLiquidoAntecipacaoParcelado
     * @return ARVDV
     */
    public function setValorLiquidoAntecipacaoParcelado($valorLiquidoAntecipacaoParcelado)
    {
        $this->valorLiquidoAntecipacaoParcelado = $valorLiquidoAntecipacaoParcelado;
        return $this;
    }

    /**
     * @return float
     */
    public function getValorLiquidoAntecipacaoPreDatado()
    {
        return $this->valorLiquidoAntecipacaoPreDatado;
    }

    /**
     * @param float $valorLiquidoAntecipacaoPreDatado
     * @return ARVDV
     */
    public function setValorLiquidoAntecipacaoPreDatado($valorLiquidoAntecipacaoPreDatado)
    {
        $this->valorLiquidoAntecipacaoPreDatado = $valorLiquidoAntecipacaoPreDatado;
        return $this;
    }

    /**
     * @return float
     */
    public function getValorLiquidoAntecipacaoTotal()
    {
        return $this->valorLiquidoAntecipacaoTotal;
    }

    /**
     * @param float $valorLiquidoAntecipacaoTotal
     * @return ARVDV
     */
    public function setValorLiquidoAntecipacaoTotal($valorLiquidoAntecipacaoTotal)
    {
        $this->valorLiquidoAntecipacaoTotal = $valorLiquidoAntecipacaoTotal;
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
     * @return ARVDV
     */
    public function setTipoRegistro($tipoRegistro)
    {
        $this->tipoRegistro = $tipoRegistro;
        return $this;
    }


}