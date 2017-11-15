<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function getUsersLikeUsername($search)
    {
        return $query = $this->getEntityManager()
            ->getRepository('AppBundle:User')
            ->createQueryBuilder('u')
            ->where("u.username like :search")
            ->setParameter("search", '%'.$search.'%')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getReverseFriendShip($userId, $friendId)
    {
        return $query = $this->getEntityManager()
            ->getRepository('AppBundle:Friend')
            ->createQueryBuilder('f')
            ->where("f.user = :userId")
            ->setParameter("userId", $userId)
            ->andWhere("f.hasFriend = :friendId")
            ->setParameter("friendId", $friendId)
            ->getQuery()
            ->getSingleResult()
        ;
    }

    public function getFriendRequests($userId)
    {
        return $query = $this->getEntityManager()
            ->getRepository('AppBundle:Friend')
            ->createQueryBuilder('f')
            ->where("f.user = :userId")
            ->setParameter("userId", $userId)
            ->andWhere("f.accepted = 0")
            ->getQuery()
            ->getResult()
        ;
    }
}
