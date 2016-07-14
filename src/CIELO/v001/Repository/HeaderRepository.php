<?php

namespace CIELO\v001\Repository;

use CIELO\v001\Entity\Header;
use Doctrine\ORM\EntityRepository;

/**
 * Class HeaderRepository
 * @package CIELO\v001\Repository
 */
class HeaderRepository extends EntityRepository
{
    public function exists(Header $header){
        return $this->findOneBy([
            'estabelecimentoMatriz' => $header->getEstabelecimentoMatriz(),
            'dataProcessamento' => $header->getDataProcessamento(),
            'sequencia' => $header->getSequencia(),
            'opcaoExtrato' => $header->getOpcaoExtrato(),
            'caixaPostal' => $header->getCaixaPostal()
        ]);
    }
}