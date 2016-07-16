<?php

namespace CIELO\v001\Repository;

use CIELO\v001\Entity\ARVRODebito;
use Doctrine\ORM\EntityRepository;

/**
 * Class ARVRODebitoRepository
 * @package CIELO\v001\Repository
 */
class ARVRODebitoRepository extends EntityRepository
{
    public function exists(ARVRODebito $arvRoDebito){
        return $this->findOneBy([
            'arvDv' => $arvRoDebito->getArvDv(),
            'estabelecimento' => $arvRoDebito->getEstabelecimento(),
            'dataPagamentoAjuste' => $arvRoDebito->getDataPagamentoAjuste(),
            'numeroRoAntecipado' => $arvRoDebito->getNumeroRoAntecipado(),
            'numeroRoVendaOriginouAjuste' => $arvRoDebito->getNumeroRoVendaOriginouAjuste(),
            'numeroUnicoRoOriginalVenda' => $arvRoDebito->getNumeroUnicoRoOriginalVenda(),
        ]);
    }
}