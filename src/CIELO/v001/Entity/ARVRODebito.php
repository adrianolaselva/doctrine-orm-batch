<?php

namespace CIELO\v001\Entity;

use CIELO\Constants\TipoRegistro;
use CIELO\Helpers\DateTimeHelper;
use CIELO\Helpers\NumberHelper;
use Doctrine\ORM\Mapping as ORM;
use Exception;

/**
 * Class ARVRODebito
 * @package CIELO\v001\Entity
 *
 * @ORM\Entity(repositoryClass="CIELO\v001\Repository\ARVRODebitoRepository")
 * @ORM\Table(name="v001_arvrodebito")
 */
class ARVRODebito
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
     * @ORM\Column(type="string", nullable=true)
     */
    protected $estabelecimento;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $numeroUnicoRoOriginalVenda;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $numeroRoAntecipado;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $dataPagamentoRoAntecipado;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $sinalValorRoAntecipado;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", nullable=true, precision=12, scale=2)
     */
    protected $valorRoAntecipado;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $numeroRoVendaOriginouAjuste;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $numeroRoAjusteADebito;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $dataPagamentoAjuste;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $sinalValorAjusteADebito;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", nullable=true, precision=12, scale=2)
     */
    protected $valorAjusteADebito;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $sinalValorCompensado;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", nullable=true, precision=12, scale=2)
     */
    protected $valorCompensado;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $sinalSaldoROAntecipado;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", nullable=true, precision=12, scale=2)
     */
    protected $valorSaldoROAntecipado;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $usoCielo;


    /**
     * ARVRODebito constructor.
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
        if(substr($line, 0, 1) != TipoRegistro::CIELO_ARV_INF_ROS_ANTECIPADOS)
            throw new Exception('Tipo registro inválido');

        if($arvDv instanceof ARVDV)
            $this->arvDv = $arvDv;

        $this->tipoRegistro = substr($line, 0,1);
        $this->estabelecimento = substr($line, 1,10);
        $this->numeroUnicoRoOriginalVenda = substr($line, 11,22);
        $this->numeroRoAntecipado = substr($line, 32,7);
        $this->dataPagamentoRoAntecipado = DateTimeHelper::formatFromToDateTime(substr($line, 40,8), 'Ymd');
        $this->sinalValorRoAntecipado = substr($line, 48,1);
        $this->valorRoAntecipado = NumberHelper::formatDecimalDiv(substr($line, 49,13));
        $this->numeroRoVendaOriginouAjuste = substr($line, 62,22);
        $this->numeroRoAjusteADebito = substr($line, 84,7);
        $this->dataPagamentoAjuste = DateTimeHelper::formatFromToDateTime(substr($line, 91,8), 'Ymd');
        $this->sinalValorAjusteADebito = substr($line, 99,1);
        $this->valorAjusteADebito = NumberHelper::formatDecimalDiv(substr($line, 100,13));
        $this->sinalValorCompensado = substr($line, 113,1);
        $this->valorCompensado = NumberHelper::formatDecimalDiv(substr($line, 114,13));
        $this->sinalSaldoROAntecipado = substr($line, 127,1);
        $this->valorRoAntecipado = NumberHelper::formatDecimalDiv(substr($line, 128,13));
        $this->usoCielo = substr($line, 141,8);

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
     * @return ARVRODebito
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return ARVDV
     */
    public function getArvDv()
    {
        return $this->arvDv;
    }

    /**
     * @param ARVDV $arvDv
     * @return ARVRODebito
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
     * @return ARVRODebito
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
     * @return ARVRODebito
     */
    public function setEstabelecimento($estabelecimento)
    {
        $this->estabelecimento = $estabelecimento;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumeroUnicoRoOriginalVenda()
    {
        return $this->numeroUnicoRoOriginalVenda;
    }

    /**
     * @param string $numeroUnicoRoOriginalVenda
     * @return ARVRODebito
     */
    public function setNumeroUnicoRoOriginalVenda($numeroUnicoRoOriginalVenda)
    {
        $this->numeroUnicoRoOriginalVenda = $numeroUnicoRoOriginalVenda;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumeroRoAntecipado()
    {
        return $this->numeroRoAntecipado;
    }

    /**
     * @param string $numeroRoAntecipado
     * @return ARVRODebito
     */
    public function setNumeroRoAntecipado($numeroRoAntecipado)
    {
        $this->numeroRoAntecipado = $numeroRoAntecipado;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDataPagamentoRoAntecipado()
    {
        return $this->dataPagamentoRoAntecipado;
    }

    /**
     * @param \DateTime $dataPagamentoRoAntecipado
     * @return ARVRODebito
     */
    public function setDataPagamentoRoAntecipado($dataPagamentoRoAntecipado)
    {
        $this->dataPagamentoRoAntecipado = $dataPagamentoRoAntecipado;
        return $this;
    }

    /**
     * @return string
     */
    public function getSinalValorRoAntecipado()
    {
        return $this->sinalValorRoAntecipado;
    }

    /**
     * @param string $sinalValorRoAntecipado
     * @return ARVRODebito
     */
    public function setSinalValorRoAntecipado($sinalValorRoAntecipado)
    {
        $this->sinalValorRoAntecipado = $sinalValorRoAntecipado;
        return $this;
    }

    /**
     * @return float
     */
    public function getValorRoAntecipado()
    {
        return $this->valorRoAntecipado;
    }

    /**
     * @param float $valorRoAntecipado
     * @return ARVRODebito
     */
    public function setValorRoAntecipado($valorRoAntecipado)
    {
        $this->valorRoAntecipado = $valorRoAntecipado;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumeroRoVendaOriginouAjuste()
    {
        return $this->numeroRoVendaOriginouAjuste;
    }

    /**
     * @param string $numeroRoVendaOriginouAjuste
     * @return ARVRODebito
     */
    public function setNumeroRoVendaOriginouAjuste($numeroRoVendaOriginouAjuste)
    {
        $this->numeroRoVendaOriginouAjuste = $numeroRoVendaOriginouAjuste;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumeroRoAjusteADebito()
    {
        return $this->numeroRoAjusteADebito;
    }

    /**
     * @param string $numeroRoAjusteADebito
     * @return ARVRODebito
     */
    public function setNumeroRoAjusteADebito($numeroRoAjusteADebito)
    {
        $this->numeroRoAjusteADebito = $numeroRoAjusteADebito;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDataPagamentoAjuste()
    {
        return $this->dataPagamentoAjuste;
    }

    /**
     * @param \DateTime $dataPagamentoAjuste
     * @return ARVRODebito
     */
    public function setDataPagamentoAjuste($dataPagamentoAjuste)
    {
        $this->dataPagamentoAjuste = $dataPagamentoAjuste;
        return $this;
    }

    /**
     * @return string
     */
    public function getSinalValorAjusteADebito()
    {
        return $this->sinalValorAjusteADebito;
    }

    /**
     * @param string $sinalValorAjusteADebito
     * @return ARVRODebito
     */
    public function setSinalValorAjusteADebito($sinalValorAjusteADebito)
    {
        $this->sinalValorAjusteADebito = $sinalValorAjusteADebito;
        return $this;
    }

    /**
     * @return float
     */
    public function getValorAjusteADebito()
    {
        return $this->valorAjusteADebito;
    }

    /**
     * @param float $valorAjusteADebito
     * @return ARVRODebito
     */
    public function setValorAjusteADebito($valorAjusteADebito)
    {
        $this->valorAjusteADebito = $valorAjusteADebito;
        return $this;
    }

    /**
     * @return string
     */
    public function getSinalValorCompensado()
    {
        return $this->sinalValorCompensado;
    }

    /**
     * @param string $sinalValorCompensado
     * @return ARVRODebito
     */
    public function setSinalValorCompensado($sinalValorCompensado)
    {
        $this->sinalValorCompensado = $sinalValorCompensado;
        return $this;
    }

    /**
     * @return float
     */
    public function getValorCompensado()
    {
        return $this->valorCompensado;
    }

    /**
     * @param float $valorCompensado
     * @return ARVRODebito
     */
    public function setValorCompensado($valorCompensado)
    {
        $this->valorCompensado = $valorCompensado;
        return $this;
    }

    /**
     * @return string
     */
    public function getSinalSaldoROAntecipado()
    {
        return $this->sinalSaldoROAntecipado;
    }

    /**
     * @param string $sinalSaldoROAntecipado
     * @return ARVRODebito
     */
    public function setSinalSaldoROAntecipado($sinalSaldoROAntecipado)
    {
        $this->sinalSaldoROAntecipado = $sinalSaldoROAntecipado;
        return $this;
    }

    /**
     * @return float
     */
    public function getValorSaldoROAntecipado()
    {
        return $this->valorSaldoROAntecipado;
    }

    /**
     * @param float $valorSaldoROAntecipado
     * @return ARVRODebito
     */
    public function setValorSaldoROAntecipado($valorSaldoROAntecipado)
    {
        $this->valorSaldoROAntecipado = $valorSaldoROAntecipado;
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
     * @return ARVRODebito
     */
    public function setUsoCielo($usoCielo)
    {
        $this->usoCielo = $usoCielo;
        return $this;
    }

}