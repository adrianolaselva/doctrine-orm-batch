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
 * @ORM\Entity(repositoryClass="CIELO\v001\Repository\RORepository")
 * @ORM\Table(name="v001_ro")
 * @ORM\HasLifecycleCallbacks()
 */
class RO
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
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="CIELO\v001\Entity\CV",
     *     mappedBy="ro",
     *     cascade={"persist", "remove", "merge"}, fetch="EXTRA_LAZY")
     */
    protected $vcs;

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
    protected $ro;

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
    protected $filler;

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
    protected $tipoTransacao;

    /**
     * @var string
     *
     * @ORM\Column(type="date", nullable=true)
     */
    protected $dataApresentacao;

    /**
     * @var string
     *
     * @ORM\Column(type="date", nullable=true)
     */
    protected $dataPrevPagamento;

    /**
     * @var string
     *
     * @ORM\Column(type="date", nullable=true)
     */
    protected $dataEnvioBanco;

    /**
     * @var string
     *
     * @ORM\Column(type="decimal", nullable=true, precision=12, scale=2)
     */
    protected $valorBruto;

    /**
     * @var string
     *
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     */
    protected $valorComissao;

    /**
     * @var string
     *
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     */
    protected $valorRejeitado;

    /**
     * @var string
     *
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     */
    protected $valorLiquido;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $banco;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $agencia;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $conta;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $statusPagamento;

    /**
     * @var string
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $qtdCVAceitos;

    /**
     * @var string
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $cieloProdutoId;

    /**
     * @var string
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $qtdCVRejeitados;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $revenda;

    /**
     * @var string
     *
     * @ORM\Column(type="date", nullable=true)
     */
    protected $dataCaptura;

    /**
     * @var string
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $cieloAjusteId;

    /**
     * @var string
     *
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     */
    protected $valorComplementar;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $produtoFinanceiro;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $operacaoFinanceira;

    /**
     * @var string
     *
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     */
    protected $valorBrutoAntecipado;

    /**
     * @var string
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $cieloBandeiraId;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $numeroUnicoRO;

    /**
     * @var string
     *
     * @ORM\Column(type="float", precision=3, scale=3, nullable=true)
     */
    protected $taxaComissao;

    /**
     * @var string
     *
     * @ORM\Column(type="float", precision=3, scale=3, nullable=true)
     */
    protected $tarifa;

    /**
     * @var string
     *
     * @ORM\Column(type="float", precision=3, scale=3, nullable=true)
     */
    protected $taxaGarantia;

    /**
     * @var string
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $meioCaptura;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $numeroLogico;

    /**
     * RO constructor.
     */
    public function __construct()
    {
        $this->vcs = new ArrayCollection();
    }

    /**
     * @param $line
     * @param Header|null $header
     * @return $this
     * @throws Exception
     */
    public function setLine($line, $header = null)
    {
        if(substr($line, 0, 1) != TipoRegistro::CIELO_RO)
            throw new Exception('Tipo registro inválido');

        if($header instanceof Header)
            $this->header = $header;
        
        $this->tipoRegistro = substr($line, 0,1);
        $this->estabelecimento = substr($line, 1,10);
        $this->ro = substr($line, 10,7);
        $this->parcela = NumberHelper::toInt(substr($line, 18,2), 1);
        $this->filler = substr($line, 20,1);
        $this->plano = NumberHelper::toInt(substr($line, 21,2), 1);
        $this->tipoTransacao = substr($line, 23,2);
        $this->dataApresentacao = DateTimeHelper::formatDateYearTruncateToDateTime(substr($line, 25,6));
        $this->dataPrevPagamento = DateTimeHelper::formatDateYearTruncateToDateTime(substr($line, 31,6));
        $this->dataEnvioBanco = DateTimeHelper::formatDateYearTruncateToDateTime(substr($line, 37,6));
        $this->valorBruto = NumberHelper::formatDecimalDiv(substr($line, 43,14));
        $this->valorComissao = NumberHelper::formatDecimalDiv(substr($line, 57,14));
        $this->valorRejeitado = NumberHelper::formatDecimalDiv(substr($line, 71,14));
        $this->valorLiquido = NumberHelper::formatDecimalDiv(substr($line, 85,14));
        $this->banco = substr($line, 99,4);
        $this->agencia = substr($line, 103,5);
        $this->conta = substr($line, 108,14);
        $this->statusPagamento = substr($line, 122,2);
        $this->qtdCVAceitos = NumberHelper::toInt(substr($line, 124,6));
        $this->qtdCVRejeitados = NumberHelper::toInt(substr($line, 132,6));
        $this->revenda = substr($line, 138,1);
        $this->dataCaptura = DateTimeHelper::formatDateYearTruncateToDateTime(substr($line, 139,6));
        $this->cieloAjusteId = substr($line, 145,2);
        $this->valorComplementar = NumberHelper::formatDecimalDiv(substr($line, 147,13));
        $this->produtoFinanceiro = substr($line, 160,1);
        $this->operacaoFinanceira = substr($line, 161,9);
        $this->valorBrutoAntecipado = NumberHelper::formatDecimalDiv(substr($line, 170,14));
        $this->cieloBandeiraId = NumberHelper::toInt(substr($line, 184,3));
        $this->numeroUnicoRO = substr($line, 187,22);
        $this->taxaComissao = NumberHelper::formatDecimalDiv(substr($line, 209,4),3);
        $this->tarifa = NumberHelper::formatDecimalDiv(substr($line, 213,5),3);
        $this->taxaGarantia = NumberHelper::formatDecimalDiv(substr($line, 218,4),3);
        $this->meioCaptura = NumberHelper::toInt(substr($line, 222,2));
        $this->numeroLogico = substr($line, 224,8);
        $this->cieloProdutoId = NumberHelper::toInt(substr($line, 232,3));

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
     * @return RO
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return RO
     */
    public function setTipoRegistro($tipoRegistro)
    {
        $this->tipoRegistro = $tipoRegistro;
        return $this;
    }

    /**
     * @return string
     */
    public function getCieloHeaderId()
    {
        return $this->cieloHeaderId;
    }

    /**
     * @param string $cieloHeaderId
     * @return RO
     */
    public function setCieloHeaderId($cieloHeaderId)
    {
        $this->cieloHeaderId = $cieloHeaderId;
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
     * @return RO
     */
    public function setEstabelecimento($estabelecimento)
    {
        $this->estabelecimento = $estabelecimento;
        return $this;
    }

    /**
     * @return string
     */
    public function getRo()
    {
        return $this->ro;
    }

    /**
     * @param string $ro
     * @return RO
     */
    public function setRo($ro)
    {
        $this->ro = $ro;
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
     * @return RO
     */
    public function setParcela($parcela)
    {
        $this->parcela = $parcela;
        return $this;
    }

    /**
     * @return string
     */
    public function getFiller()
    {
        return $this->filler;
    }

    /**
     * @param string $filler
     * @return RO
     */
    public function setFiller($filler)
    {
        $this->filler = $filler;
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
     * @return RO
     */
    public function setPlano($plano)
    {
        $this->plano = $plano;
        return $this;
    }

    /**
     * @return string
     */
    public function getTipoTransacao()
    {
        return $this->tipoTransacao;
    }

    /**
     * @param string $tipoTransacao
     * @return RO
     */
    public function setTipoTransacao($tipoTransacao)
    {
        $this->tipoTransacao = $tipoTransacao;
        return $this;
    }

    /**
     * @return string
     */
    public function getDataApresentacao()
    {
        return $this->dataApresentacao;
    }

    /**
     * @param string $dataApresentacao
     * @return RO
     */
    public function setDataApresentacao($dataApresentacao)
    {
        $this->dataApresentacao = $dataApresentacao;
        return $this;
    }

    /**
     * @return string
     */
    public function getDataPrevPagamento()
    {
        return $this->dataPrevPagamento;
    }

    /**
     * @param string $dataPrevPagamento
     * @return RO
     */
    public function setDataPrevPagamento($dataPrevPagamento)
    {
        $this->dataPrevPagamento = $dataPrevPagamento;
        return $this;
    }

    /**
     * @return string
     */
    public function getDataEnvioBanco()
    {
        return $this->dataEnvioBanco;
    }

    /**
     * @param string $dataEnvioBanco
     * @return RO
     */
    public function setDataEnvioBanco($dataEnvioBanco)
    {
        $this->dataEnvioBanco = $dataEnvioBanco;
        return $this;
    }

    /**
     * @return string
     */
    public function getValorBruto()
    {
        return $this->valorBruto;
    }

    /**
     * @param string $valorBruto
     * @return RO
     */
    public function setValorBruto($valorBruto)
    {
        $this->valorBruto = $valorBruto;
        return $this;
    }

    /**
     * @return string
     */
    public function getValorComissao()
    {
        return $this->valorComissao;
    }

    /**
     * @param string $valorComissao
     * @return RO
     */
    public function setValorComissao($valorComissao)
    {
        $this->valorComissao = $valorComissao;
        return $this;
    }

    /**
     * @return string
     */
    public function getValorRejeitado()
    {
        return $this->valorRejeitado;
    }

    /**
     * @param string $valorRejeitado
     * @return RO
     */
    public function setValorRejeitado($valorRejeitado)
    {
        $this->valorRejeitado = $valorRejeitado;
        return $this;
    }

    /**
     * @return string
     */
    public function getValorLiquido()
    {
        return $this->valorLiquido;
    }

    /**
     * @param string $valorLiquido
     * @return RO
     */
    public function setValorLiquido($valorLiquido)
    {
        $this->valorLiquido = $valorLiquido;
        return $this;
    }

    /**
     * @return string
     */
    public function getBanco()
    {
        return $this->banco;
    }

    /**
     * @param string $banco
     * @return RO
     */
    public function setBanco($banco)
    {
        $this->banco = $banco;
        return $this;
    }

    /**
     * @return string
     */
    public function getAgencia()
    {
        return $this->agencia;
    }

    /**
     * @param string $agencia
     * @return RO
     */
    public function setAgencia($agencia)
    {
        $this->agencia = $agencia;
        return $this;
    }

    /**
     * @return string
     */
    public function getConta()
    {
        return $this->conta;
    }

    /**
     * @param string $conta
     * @return RO
     */
    public function setConta($conta)
    {
        $this->conta = $conta;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatusPagamento()
    {
        return $this->statusPagamento;
    }

    /**
     * @param string $statusPagamento
     * @return RO
     */
    public function setStatusPagamento($statusPagamento)
    {
        $this->statusPagamento = $statusPagamento;
        return $this;
    }

    /**
     * @return string
     */
    public function getQtdCVAceitos()
    {
        return $this->qtdCVAceitos;
    }

    /**
     * @param string $qtdCVAceitos
     * @return RO
     */
    public function setQtdCVAceitos($qtdCVAceitos)
    {
        $this->qtdCVAceitos = $qtdCVAceitos;
        return $this;
    }

    /**
     * @return string
     */
    public function getCieloProdutoId()
    {
        return $this->cieloProdutoId;
    }

    /**
     * @param string $cieloProdutoId
     * @return RO
     */
    public function setCieloProdutoId($cieloProdutoId)
    {
        $this->cieloProdutoId = $cieloProdutoId;
        return $this;
    }

    /**
     * @return string
     */
    public function getQtdCVRejeitados()
    {
        return $this->qtdCVRejeitados;
    }

    /**
     * @param string $qtdCVRejeitados
     * @return RO
     */
    public function setQtdCVRejeitados($qtdCVRejeitados)
    {
        $this->qtdCVRejeitados = $qtdCVRejeitados;
        return $this;
    }

    /**
     * @return string
     */
    public function getRevenda()
    {
        return $this->revenda;
    }

    /**
     * @param string $revenda
     * @return RO
     */
    public function setRevenda($revenda)
    {
        $this->revenda = $revenda;
        return $this;
    }

    /**
     * @return string
     */
    public function getDataCaptura()
    {
        return $this->dataCaptura;
    }

    /**
     * @param string $dataCaptura
     * @return RO
     */
    public function setDataCaptura($dataCaptura)
    {
        $this->dataCaptura = $dataCaptura;
        return $this;
    }

    /**
     * @return string
     */
    public function getCieloAjusteId()
    {
        return $this->cieloAjusteId;
    }

    /**
     * @param string $cieloAjusteId
     * @return RO
     */
    public function setCieloAjusteId($cieloAjusteId)
    {
        $this->cieloAjusteId = $cieloAjusteId;
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
     * @return RO
     */
    public function setValorComplementar($valorComplementar)
    {
        $this->valorComplementar = $valorComplementar;
        return $this;
    }

    /**
     * @return string
     */
    public function getProdutoFinanceiro()
    {
        return $this->produtoFinanceiro;
    }

    /**
     * @param string $produtoFinanceiro
     * @return RO
     */
    public function setProdutoFinanceiro($produtoFinanceiro)
    {
        $this->produtoFinanceiro = $produtoFinanceiro;
        return $this;
    }

    /**
     * @return string
     */
    public function getOperacaoFinanceira()
    {
        return $this->operacaoFinanceira;
    }

    /**
     * @param string $operacaoFinanceira
     * @return RO
     */
    public function setOperacaoFinanceira($operacaoFinanceira)
    {
        $this->operacaoFinanceira = $operacaoFinanceira;
        return $this;
    }

    /**
     * @return string
     */
    public function getValorBrutoAntecipado()
    {
        return $this->valorBrutoAntecipado;
    }

    /**
     * @param string $valorBrutoAntecipado
     * @return RO
     */
    public function setValorBrutoAntecipado($valorBrutoAntecipado)
    {
        $this->valorBrutoAntecipado = $valorBrutoAntecipado;
        return $this;
    }

    /**
     * @return string
     */
    public function getCieloBandeiraId()
    {
        return $this->cieloBandeiraId;
    }

    /**
     * @param string $cieloBandeiraId
     * @return RO
     */
    public function setCieloBandeiraId($cieloBandeiraId)
    {
        $this->cieloBandeiraId = $cieloBandeiraId;
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
     * @return RO
     */
    public function setNumeroUnicoRO($numeroUnicoRO)
    {
        $this->numeroUnicoRO = $numeroUnicoRO;
        return $this;
    }

    /**
     * @return string
     */
    public function getTaxaComissao()
    {
        return $this->taxaComissao;
    }

    /**
     * @param string $taxaComissao
     * @return RO
     */
    public function setTaxaComissao($taxaComissao)
    {
        $this->taxaComissao = $taxaComissao;
        return $this;
    }

    /**
     * @return string
     */
    public function getTarifa()
    {
        return $this->tarifa;
    }

    /**
     * @param string $tarifa
     * @return RO
     */
    public function setTarifa($tarifa)
    {
        $this->tarifa = $tarifa;
        return $this;
    }

    /**
     * @return string
     */
    public function getTaxaGarantia()
    {
        return $this->taxaGarantia;
    }

    /**
     * @param string $taxaGarantia
     * @return RO
     */
    public function setTaxaGarantia($taxaGarantia)
    {
        $this->taxaGarantia = $taxaGarantia;
        return $this;
    }

    /**
     * @return string
     */
    public function getMeioCaptura()
    {
        return $this->meioCaptura;
    }

    /**
     * @param string $meioCaptura
     * @return RO
     */
    public function setMeioCaptura($meioCaptura)
    {
        $this->meioCaptura = $meioCaptura;
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
     * @return RO
     */
    public function setNumeroLogico($numeroLogico)
    {
        $this->numeroLogico = $numeroLogico;
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
     * @return RO
     */
    public function setHeader($header)
    {
        $this->header = $header;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getVcs()
    {
        return $this->vcs;
    }

    /**
     * @param ArrayCollection $vc
     * @return $this
     */
    public function addVcs(ArrayCollection $vc)
    {
        $this->vcs->add($vc);
        return $this;
    }



}