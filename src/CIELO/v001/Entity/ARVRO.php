<?php

namespace CIELO\v001\Entity;

use CIELO\Constants\TipoRegistro;
use CIELO\Helpers\DateTimeHelper;
use CIELO\Helpers\NumberHelper;
use Doctrine\ORM\Mapping as ORM;
use Exception;

/**
 * Class ARVRO
 * @package CIELO\v001\Entity
 *
 * @ORM\Entity(repositoryClass="CIELO\v001\Repository\ARVRORepository")
 * @ORM\Table(name="v001_arvro", uniqueConstraints={@ORM\UniqueConstraint(
 *          name="arvro_unique",
 *          columns={
 *     "id_arvDv","estabelecimento",
 *     "numeroOperacaoAntecipacao","dataVencimentoRO",
 *     "numeroROAntecipado","parcelaAntecipada","totalParcelas",
 *     "valorBrutoOriginalRO","valorLiquidoOriginalRO",
 *     "valorBrutoAntecipacaoRO","codigoBandeira",
 *     "valorLiquidoAntecipacaoRO"
 *          }
 *     )})
 */
class ARVRO
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
     * @var ARVDV
     *
     * @ORM\ManyToOne(targetEntity="CIELO\v001\Entity\ARVDV", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="id_arvdv", referencedColumnName="id", nullable=false)
     */
    protected $arvDv;

    /**
     * @var string
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $tipoRegistro;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=30,nullable=true)
     */
    protected $estabelecimento;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=30,nullable=true)
     */
    protected $numeroOperacaoAntecipacao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $dataVencimentoRO;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=30,nullable=true)
     */
    protected $numeroROAntecipado;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=10,nullable=true)
     */
    protected $parcelaAntecipada;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=10,nullable=true)
     */
    protected $totalParcelas;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=2,nullable=true)
     */
    protected $sinalValorBrutoOriginalRO;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", nullable=true, precision=12, scale=2)
     */
    protected $valorBrutoOriginalRO;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=2,nullable=true)
     */
    protected $sinalValorLiquidoOriginalRO;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", nullable=true, precision=12, scale=2)
     */
    protected $valorLiquidoOriginalRO;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=2,nullable=true)
     */
    protected $sinalValorBrutoAntecipacaoRO;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", nullable=true, precision=12, scale=2)
     */
    protected $valorBrutoAntecipacaoRO;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=2,nullable=true)
     */
    protected $sinalValorLiquidoAntecipacaoRO;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", nullable=true, precision=12, scale=2)
     */
    protected $valorLiquidoAntecipacaoRO;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=20,nullable=true)
     */
    protected $codigoBandeira;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=30,nullable=true)
     */
    protected $numeroUnicoRO;

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

    }

    /**
     * @param $line
     * @param ARVDV $arvDv
     * @return $this
     * @throws Exception
     */
    public function setLine($line, $arvDv = null)
    {
        if(substr($line, 0, 1) != TipoRegistro::CIELO_ARV_RO)
            throw new Exception('Tipo registro inválido');

        if($arvDv instanceof ARVDV)
            $this->arvDv = $arvDv;

        $this->tipoRegistro = substr($line, 0,1);
        $this->estabelecimento = substr($line, 1,10);
        $this->numeroOperacaoAntecipacao = substr($line, 11,9);
        $this->dataVencimentoRO = DateTimeHelper::formatFromToDateTime(substr($line, 20,8), 'Ymd');
        $this->numeroROAntecipado = substr($line, 28,7);
        $this->parcelaAntecipada = substr($line, 35,2);
        $this->totalParcelas = substr($line, 37,2);
        $this->sinalValorBrutoOriginalRO = substr($line, 39,1);
        $this->valorBrutoOriginalRO = NumberHelper::formatDecimalDiv(substr($line, 40,13));
        $this->sinalValorLiquidoOriginalRO = substr($line, 53,1);
        $this->valorLiquidoOriginalRO = NumberHelper::formatDecimalDiv(substr($line, 54,13));
        $this->sinalValorBrutoAntecipacaoRO = substr($line, 67,1);
        $this->valorBrutoAntecipacaoRO = NumberHelper::formatDecimalDiv(substr($line, 68,13));
        $this->sinalValorLiquidoAntecipacaoRO = substr($line, 81,1);
        $this->valorLiquidoAntecipacaoRO = NumberHelper::formatDecimalDiv(substr($line, 82,13));
        $this->codigoBandeira = substr($line, 95,3);
        $this->numeroUnicoRO = substr($line, 98,22);
        $this->usoCielo = substr($line, 120,130);

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
     * @return ARVRO
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Header
     */
    public function getArvDv()
    {
        return $this->arvDv;
    }

    /**
     * @param Header $arvDv
     * @return ARVRO
     */
    public function setArvDv($arvDv)
    {
        $this->arvDv = $arvDv;
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
     * @return ARVRO
     */
    public function setTipoRegistro($tipoRegistro)
    {
        $this->tipoRegistro = $tipoRegistro;
        return $this;
    }

    /**
     * @return string
     */
    public function getEstabelecimento()
    {
        return $this->estabelecimento;
    }

    /**
     * @param string $estabelecimento
     * @return ARVRO
     */
    public function setEstabelecimento($estabelecimento)
    {
        $this->estabelecimento = $estabelecimento;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumeroOperacaoAntecipacao()
    {
        return $this->numeroOperacaoAntecipacao;
    }

    /**
     * @param string $numeroOperacaoAntecipacao
     * @return ARVRO
     */
    public function setNumeroOperacaoAntecipacao($numeroOperacaoAntecipacao)
    {
        $this->numeroOperacaoAntecipacao = $numeroOperacaoAntecipacao;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDataVencimentoRO()
    {
        return $this->dataVencimentoRO;
    }

    /**
     * @param \DateTime $dataVencimentoRO
     * @return ARVRO
     */
    public function setDataVencimentoRO($dataVencimentoRO)
    {
        $this->dataVencimentoRO = $dataVencimentoRO;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumeroROAntecipado()
    {
        return $this->numeroROAntecipado;
    }

    /**
     * @param string $numeroROAntecipado
     * @return ARVRO
     */
    public function setNumeroROAntecipado($numeroROAntecipado)
    {
        $this->numeroROAntecipado = $numeroROAntecipado;
        return $this;
    }

    /**
     * @return string
     */
    public function getParcelaAntecipada()
    {
        return $this->parcelaAntecipada;
    }

    /**
     * @param string $parcelaAntecipada
     * @return ARVRO
     */
    public function setParcelaAntecipada($parcelaAntecipada)
    {
        $this->parcelaAntecipada = $parcelaAntecipada;
        return $this;
    }

    /**
     * @return string
     */
    public function getTotalParcelas()
    {
        return $this->totalParcelas;
    }

    /**
     * @param string $totalParcelas
     * @return ARVRO
     */
    public function setTotalParcelas($totalParcelas)
    {
        $this->totalParcelas = $totalParcelas;
        return $this;
    }

    /**
     * @return string
     */
    public function getSinalValorBrutoOriginalRO()
    {
        return $this->sinalValorBrutoOriginalRO;
    }

    /**
     * @param string $sinalValorBrutoOriginalRO
     * @return ARVRO
     */
    public function setSinalValorBrutoOriginalRO($sinalValorBrutoOriginalRO)
    {
        $this->sinalValorBrutoOriginalRO = $sinalValorBrutoOriginalRO;
        return $this;
    }

    /**
     * @return float
     */
    public function getValorBrutoOriginalRO()
    {
        return $this->valorBrutoOriginalRO;
    }

    /**
     * @param float $valorBrutoOriginalRO
     * @return ARVRO
     */
    public function setValorBrutoOriginalRO($valorBrutoOriginalRO)
    {
        $this->valorBrutoOriginalRO = $valorBrutoOriginalRO;
        return $this;
    }

    /**
     * @return string
     */
    public function getSinalValorLiquidoOriginalRO()
    {
        return $this->sinalValorLiquidoOriginalRO;
    }

    /**
     * @param string $sinalValorLiquidoOriginalRO
     * @return ARVRO
     */
    public function setSinalValorLiquidoOriginalRO($sinalValorLiquidoOriginalRO)
    {
        $this->sinalValorLiquidoOriginalRO = $sinalValorLiquidoOriginalRO;
        return $this;
    }

    /**
     * @return float
     */
    public function getValorLiquidoOriginalRO()
    {
        return $this->valorLiquidoOriginalRO;
    }

    /**
     * @param float $valorLiquidoOriginalRO
     * @return ARVRO
     */
    public function setValorLiquidoOriginalRO($valorLiquidoOriginalRO)
    {
        $this->valorLiquidoOriginalRO = $valorLiquidoOriginalRO;
        return $this;
    }

    /**
     * @return string
     */
    public function getSinalValorBrutoAntecipacaoRO()
    {
        return $this->sinalValorBrutoAntecipacaoRO;
    }

    /**
     * @param string $sinalValorBrutoAntecipacaoRO
     * @return ARVRO
     */
    public function setSinalValorBrutoAntecipacaoRO($sinalValorBrutoAntecipacaoRO)
    {
        $this->sinalValorBrutoAntecipacaoRO = $sinalValorBrutoAntecipacaoRO;
        return $this;
    }

    /**
     * @return float
     */
    public function getValorBrutoAntecipacaoRO()
    {
        return $this->valorBrutoAntecipacaoRO;
    }

    /**
     * @param float $valorBrutoAntecipacaoRO
     * @return ARVRO
     */
    public function setValorBrutoAntecipacaoRO($valorBrutoAntecipacaoRO)
    {
        $this->valorBrutoAntecipacaoRO = $valorBrutoAntecipacaoRO;
        return $this;
    }

    /**
     * @return string
     */
    public function getSinalValorLiquidoAntecipacaoRO()
    {
        return $this->sinalValorLiquidoAntecipacaoRO;
    }

    /**
     * @param string $sinalValorLiquidoAntecipacaoRO
     * @return ARVRO
     */
    public function setSinalValorLiquidoAntecipacaoRO($sinalValorLiquidoAntecipacaoRO)
    {
        $this->sinalValorLiquidoAntecipacaoRO = $sinalValorLiquidoAntecipacaoRO;
        return $this;
    }

    /**
     * @return float
     */
    public function getValorLiquidoAntecipacaoRO()
    {
        return $this->valorLiquidoAntecipacaoRO;
    }

    /**
     * @param float $valorLiquidoAntecipacaoRO
     * @return ARVRO
     */
    public function setValorLiquidoAntecipacaoRO($valorLiquidoAntecipacaoRO)
    {
        $this->valorLiquidoAntecipacaoRO = $valorLiquidoAntecipacaoRO;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodigoBandeira()
    {
        return $this->codigoBandeira;
    }

    /**
     * @param string $codigoBandeira
     * @return ARVRO
     */
    public function setCodigoBandeira($codigoBandeira)
    {
        $this->codigoBandeira = $codigoBandeira;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumeroUnicoRO()
    {
        return $this->numeroUnicoRO;
    }

    /**
     * @param string $numeroUnicoRO
     * @return ARVRO
     */
    public function setNumeroUnicoRO($numeroUnicoRO)
    {
        $this->numeroUnicoRO = $numeroUnicoRO;
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
     * @return ARVRO
     */
    public function setUsoCielo($usoCielo)
    {
        $this->usoCielo = $usoCielo;
        return $this;
    }

}