<?php

namespace CIELO\v001\Repository;

use CIELO\v001\Entity\Header;
use CIELO\v001\Entity\RO;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\AST\Join;

/**
 * Class RORepository
 * @package CIELO\v001\Repository
 */
class RORepository extends EntityRepository
{
    public function exists(RO $ro){
        return $this->findOneBy([
            'header' => $ro->getHeader(),
            'numeroUnicoRO' => $ro->getNumeroUnicoRO(),
            //'ro' => $ro->getRo(),
        ]);
    }
}