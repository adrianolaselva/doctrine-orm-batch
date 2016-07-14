<?php

namespace CIELO\v001\Entity;

use CIELO\Constants\TipoRegistro;
use CIELO\Helpers\DateTimeHelper;
use CIELO\Helpers\NumberHelper;
use Doctrine\ORM\Mapping as ORM;
use Exception;


/**
 * Class CV
 * @package CIELO\v001\Entity
 * 
 * @ORM\Entity(repositoryClass="CIELO\v001\Repository\CVRepository")
 * @ORM\Table(name="v001_cv")
 */
class CV
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
     * @var RO
     *
     * @ORM\ManyToOne(targetEntity="CIELO\v001\Entity\RO", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="id_ro", referencedColumnName="id", nullable=false)
     */
    protected $ro;

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
    protected $estabelecimento;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $numeroRO;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $numeroCartao;

    /**
     * @var string
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $dataVenda;

    /**
     * @var string
     *
     * @ORM\Column(type="decimal", nullable=true, precision=12, scale=2)
     */
    protected $valor;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $parcela;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $plano;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $cieloIdRejeicao;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $autorizacao;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $tId;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $nsu;

    /**
     * @var string
     *
     * @ORM\Column(type="decimal", nullable=true, precision=12, scale=2)
     */
    protected $valorComplementar;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $qtdDigitosCartao;

    /**
     * @var string
     *
     * @ORM\Column(type="decimal", nullable=true, precision=12, scale=2)
     */
    protected $valorTotal;

    /**
     * @var string
     *
     * @ORM\Column(type="decimal", nullable=true, precision=12, scale=2)
     */
    protected $valorProxParcela;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $nf;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $cartaoExterior;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $numeroLogico;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $indicadorTxEmbarque;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $referencia;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $horaTransacao;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $numeroUnicoTransacao;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $indicadorPP;

    /**
     * CV constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param $line
     * @param null $ro
     * @return $this
     * @throws Exception
     */
    public function setLine($line, $ro = null)
    {
        if(substr($line, 0, 1) != TipoRegistro::CIELO_CV)
            throw new Exception('Tipo registro inválido');

        if($ro instanceof RO)
            $this->ro = $ro;

        $this->tipoRegistro = substr($line, 0,1);
        $this->estabelecimento = substr($line, 1,10);
        $this->ro = substr($line, 10,7);
        $this->numeroCartao = substr($line, 18,19);
        $this->dataVenda = DateTimeHelper::formatDateYearTruncateToDateTime(substr($line, 39,6));
        $this->valor = NumberHelper::formatDecimalDiv(substr($line, 45,14));
        $this->parcela = substr($line, 59,2);
        $this->plano = substr($line, 61,2);
        $this->cieloIdRejeicao = substr($line, 63,3);
        $this->autorizacao = substr($line, 66,6);
        $this->tId = substr($line, 72,20);
        $this->nsu = substr($line, 92,6);
        $this->valorComplementar = NumberHelper::formatDecimalDiv(substr($line, 98,13));
        $this->qtdDigitosCartao = substr($line, 111,2);
        $this->valorTotal = NumberHelper::formatDecimalDiv(substr($line, 113,13));
        $this->valorProxParcela = NumberHelper::formatDecimalDiv(substr($line, 126,13));
        $this->nf = substr($line, 139,9);
        $this->cartaoExterior = substr($line, 148,4);
        $this->numeroLogico = substr($line, 152,8);
        $this->indicadorTxEmbarque = substr($line, 160,2);
        $this->referencia = substr($line, 162,20);
        $this->horaTransacao = substr($line, 182,6);
        $this->numeroUnicoTransacao = substr($line, 188,29);
        $this->indicadorPP = substr($line, 217,1);
        
        return $this;
    }

    /**
     * @return string
     */
    public function getAutorizacao()
    {
        return $this->autorizacao;
    }

    /**
     * @param string $autorizacao
     * @return CV
     */
    public function setAutorizacao($autorizacao)
    {
        $this->autorizacao = $autorizacao;
        return $this;
    }

    /**
     * @return string
     */
    public function getCartaoExterior()
    {
        return $this->cartaoExterior;
    }

    /**
     * @param string $cartaoExterior
     * @return CV
     */
    public function setCartaoExterior($cartaoExterior)
    {
        $this->cartaoExterior = $cartaoExterior;
        return $this;
    }

    /**
     * @return string
     */
    public function getCieloIdRejeicao()
    {
        return $this->cieloIdRejeicao;
    }

    /**
     * @param string $cieloIdRejeicao
     * @return CV
     */
    public function setCieloIdRejeicao($cieloIdRejeicao)
    {
        $this->cieloIdRejeicao = $cieloIdRejeicao;
        return $this;
    }

    /**
     * @return string
     */
    public function getDataVenda()
    {
        return $this->dataVenda;
    }

    /**
     * @param string $dataVenda
     * @return CV
     */
    public function setDataVenda($dataVenda)
    {
        $this->dataVenda = $dataVenda;
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
     * @return CV
     */
    public function setEstabelecimento($estabelecimento)
    {
        $this->estabelecimento = $estabelecimento;
        return $this;
    }

    /**
     * @return string
     */
    public function getHoraTransacao()
    {
        return $this->horaTransacao;
    }

    /**
     * @param string $horaTransacao
     * @return CV
     */
    public function setHoraTransacao($horaTransacao)
    {
        $this->horaTransacao = $horaTransacao;
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
     * @return CV
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getIndicadorPP()
    {
        return $this->indicadorPP;
    }

    /**
     * @param string $indicadorPP
     * @return CV
     */
    public function setIndicadorPP($indicadorPP)
    {
        $this->indicadorPP = $indicadorPP;
        return $this;
    }

    /**
     * @return string
     */
    public function getIndicadorTxEmbarque()
    {
        return $this->indicadorTxEmbarque;
    }

    /**
     * @param string $indicadorTxEmbarque
     * @return CV
     */
    public function setIndicadorTxEmbarque($indicadorTxEmbarque)
    {
        $this->indicadorTxEmbarque = $indicadorTxEmbarque;
        return $this;
    }

    /**
     * @return string
     */
    public function getNf()
    {
        return $this->nf;
    }

    /**
     * @param string $nf
     * @return CV
     */
    public function setNf($nf)
    {
        $this->nf = $nf;
        return $this;
    }

    /**
     * @return string
     */
    public function getNsu()
    {
        return $this->nsu;
    }

    /**
     * @param string $nsu
     * @return CV
     */
    public function setNsu($nsu)
    {
        $this->nsu = $nsu;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumeroCartao()
    {
        return $this->numeroCartao;
    }

    /**
     * @param string $numeroCartao
     * @return CV
     */
    public function setNumeroCartao($numeroCartao)
    {
        $this->numeroCartao = $numeroCartao;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumeroLogico()
    {
        return $this->numeroLogico;
    }

    /**
     * @param string $numeroLogico
     * @return CV
     */
    public function setNumeroLogico($numeroLogico)
    {
        $this->numeroLogico = $numeroLogico;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumeroRO()
    {
        return $this->numeroRO;
    }

    /**
     * @param string $numeroRO
     * @return CV
     */
    public function setNumeroRO($numeroRO)
    {
        $this->numeroRO = $numeroRO;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumeroUnicoTransacao()
    {
        return $this->numeroUnicoTransacao;
    }

    /**
     * @param string $numeroUnicoTransacao
     * @return CV
     */
    public function setNumeroUnicoTransacao($numeroUnicoTransacao)
    {
        $this->numeroUnicoTransacao = $numeroUnicoTransacao;
        return $this;
    }

    /**
     * @return string
     */
    public function getParcela()
    {
        return $this->parcela;
    }

    /**
     * @param string $parcela
     * @return CV
     */
    public function setParcela($parcela)
    {
        $this->parcela = $parcela;
        return $this;
    }

    /**
     * @return string
     */
    public function getPlano()
    {
        return $this->plano;
    }

    /**
     * @param string $plano
     * @return CV
     */
    public function setPlano($plano)
    {
        $this->plano = $plano;
        return $this;
    }

    /**
     * @return string
     */
    public function getQtdDigitosCartao()
    {
        return $this->qtdDigitosCartao;
    }

    /**
     * @param string $qtdDigitosCartao
     * @return CV
     */
    public function setQtdDigitosCartao($qtdDigitosCartao)
    {
        $this->qtdDigitosCartao = $qtdDigitosCartao;
        return $this;
    }

    /**
     * @return string
     */
    public function getReferencia()
    {
        return $this->referencia;
    }

    /**
     * @param string $referencia
     * @return CV
     */
    public function setReferencia($referencia)
    {
        $this->referencia = $referencia;
        return $this;
    }

    /**
     * @return RO
     */
    public function getRo()
    {
        return $this->ro;
    }

    /**
     * @param RO $ro
     * @return CV
     */
    public function setRo($ro)
    {
        $this->ro = $ro;
        return $this;
    }

    /**
     * @return string
     */
    public function getTId()
    {
        return $this->tId;
    }

    /**
     * @param string $tId
     * @return CV
     */
    public function setTId($tId)
    {
        $this->tId = $tId;
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
     * @return CV
     */
    public function setTipoRegistro($tipoRegistro)
    {
        $this->tipoRegistro = $tipoRegistro;
        return $this;
    }

    /**
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param string $valor
     * @return CV
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * @return string
     */
    public function getValorComplementar()
    {
        return $this->valorComplementar;
    }

    /**
     * @param string $valorComplementar
     * @return CV
     */
    public function setValorComplementar($valorComplementar)
    {
        $this->valorComplementar = $valorComplementar;
        return $this;
    }

    /**
     * @return string
     */
    public function getValorProxParcela()
    {
        return $this->valorProxParcela;
    }

    /**
     * @param string $valorProxParcela
     * @return CV
     */
    public function setValorProxParcela($valorProxParcela)
    {
        $this->valorProxParcela = $valorProxParcela;
        return $this;
    }

    /**
     * @return string
     */
    public function getValorTotal()
    {
        return $this->valorTotal;
    }

    /**
     * @param string $valorTotal
     * @return CV
     */
    public function setValorTotal($valorTotal)
    {
        $this->valorTotal = $valorTotal;
        return $this;
    }

}