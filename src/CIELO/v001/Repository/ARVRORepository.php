<?php

namespace CIELO\v001\Repository;

use CIELO\v001\Entity\ARVRO;
use Doctrine\ORM\EntityRepository;

/**
 * Class ARVRORepository
 * @package CIELO\v001\Repository
 */
class ARVRORepository extends EntityRepository
{
    public function exists(ARVRO $arvRo){
        return $this->findOneBy([
            'arvDv' => $arvRo->getArvDv(),
            'estabelecimento' => $arvRo->getEstabelecimento(),
            'dataVencimentoRO' => $arvRo->getDataVencimentoRO(),
            'numeroUnicoRO' => $arvRo->getNumeroUnicoRO(),
            'numeroOperacaoAntecipacao' => $arvRo->getNumeroOperacaoAntecipacao(),
            'parcelaAntecipada' => $arvRo->getParcelaAntecipada(),
            'totalParcelas' => $arvRo->getTotalParcelas(),
            'codigoBandeira' => $arvRo->getCodigoBandeira(),
            'valorBrutoAntecipacaoRO' => $arvRo->getValorBrutoAntecipacaoRO(),
            'valorBrutoOriginalRO' => $arvRo->getValorBrutoOriginalRO(),
            'valorLiquidoAntecipacaoRO' => $arvRo->getValorLiquidoAntecipacaoRO(),
            'sinalValorLiquidoOriginalRO' => $arvRo->getSinalValorLiquidoOriginalRO(),
        ]);
    }
}