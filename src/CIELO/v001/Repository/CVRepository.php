<?php

namespace CIELO\v001\Repository;

use CIELO\v001\Entity\CV;
use CIELO\v001\Entity\RO;
use Doctrine\ORM\EntityRepository;

/**
 * Class CVRepository
 * @package CIELO\v001\Repository
 */
class CVRepository extends EntityRepository
{
    public function exists(CV $ro){
        return $this->findOneBy([
            'ro' => $ro->getRo(),
            'estabelecimento' => $ro->getEstabelecimento(),
            'numeroCartao' => $ro->getNumeroCartao(),
            'numeroLogico' => $ro->getNumeroLogico(),
            'autorizacao' => $ro->getAutorizacao(),
            'dataVenda' => $ro->getDataVenda(),
        ]);
    }
}