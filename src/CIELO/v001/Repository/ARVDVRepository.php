<?php

namespace CIELO\v001\Repository;

use CIELO\v001\Entity\ARVDV;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityRepository;

/**
 * Class ARVDVRepository
 * @package CIELO\v001\Repository
 */
class ARVDVRepository extends EntityRepository
{
    public function exists(ARVDV $arvDv){
        return $this->findOneBy([
            'header' => $arvDv->getHeader(),
            'dataCreditoOperacao' => $arvDv->getDataCreditoOperacao(),
            'numeroOperacaoFinanceira' => $arvDv->getNumeroOperacaoFinanceira(),
            'valorBrutoAntecipacaoAVista' => $arvDv->getValorBrutoAntecipacaoAVista(),
            'valorBrutoAntecipacaoParcelado' => $arvDv->getValorBrutoAntecipacaoParcelado(),
            'valorBrutoAntecipacaoEletronPreDatado' => $arvDv->getValorBrutoAntecipacaoEletronPreDatado(),
            'valorBrutoAntecipacaoTotal' => $arvDv->getValorBrutoAntecipacaoTotal(),
            'valorLiquidoAntecipacaoAVista' => $arvDv->getValorLiquidoAntecipacaoAVista(),
            'valorLiquidoAntecipacaoParcelado' => $arvDv->getValorLiquidoAntecipacaoParcelado(),
            'valorLiquidoAntecipacaoTotal' => $arvDv->getValorLiquidoAntecipacaoTotal(),
        ]);
    }


}