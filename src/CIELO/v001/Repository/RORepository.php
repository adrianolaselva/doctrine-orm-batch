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
    public function exists(RO $header){
//        $queryBuilder = $this->createQueryBuilder("ro")
//            ->innerJoin('ro.header','he', Join::WITH, 'ro.header','he.id');
//
//        $queryBuilder->andWhere('he.id like :id');
//        $queryBuilder->setParameter('id', $header->getId());
//
//        $queryBuilder->andWhere('he.id like :id');
//        $queryBuilder->setParameter('id', $header->getId());

        return $this->findOneBy([
            'header' => $header->getHeader(),
            'numeroUnicoRO' => $header->getNumeroUnicoRO(),
            'ro' => $header->getRo()
        ]);
    }
}