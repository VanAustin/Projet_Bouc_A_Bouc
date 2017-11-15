<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CollectionRepository extends EntityRepository
{
    public function getLoanRequests($id)
    {
        return $query = $this->getEntityManager()
            ->getRepository('AppBundle:Collection')
            ->createQueryBuilder('c')
            ->where('c.borrowAsk = true')
            ->andWhere('c.borrowed = false')
            ->andWhere("c.user = :id")
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
        ;
    }
}
