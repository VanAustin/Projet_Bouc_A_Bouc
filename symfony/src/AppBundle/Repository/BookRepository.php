<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class BookRepository extends EntityRepository
{
    public function getUserBooksCollectionByTitleOrIsbn($search, $userId)
    {
        return $query = $this->getEntityManager()
            ->getRepository('AppBundle:Book')
            ->createQueryBuilder('b')
            ->orWhere("b.title like :search")
            ->setParameter("search", '%'.$search.'%')
            ->orWhere("b.isbn10 like :search")
            ->setParameter("search", '%'.$search.'%')
            ->orWhere("b.isbn13 like :search")
            ->setParameter("search", '%'.$search.'%')
            ->join('b.collections', 'c')
            ->andWhere("c.user = :userId")
            ->setParameter("userId", $userId)
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function getUserBooksCollectionByAuthor($search, $userId)
    {
        return $query = $this->getEntityManager()
            ->getRepository('AppBundle:Book')
            ->createQueryBuilder('b')
            ->join('b.authors', 'a')
            ->orWhere("a.authorName like :search")
            ->setParameter("search", '%'.$search.'%')
            ->join('b.collections', 'c')
            ->andWhere("c.user = :userId")
            ->setParameter("userId", $userId)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getUserWishBooksByTitleOrIsbn($search, $userId)
    {
        return $query = $this->getEntityManager()
            ->getRepository('AppBundle:Book')
            ->createQueryBuilder('b')
            ->orWhere("b.title like :search")
            ->setParameter("search", '%'.$search.'%')
            ->orWhere("b.isbn10 like :search")
            ->setParameter("search", '%'.$search.'%')
            ->orWhere("b.isbn13 like :search")
            ->setParameter("search", '%'.$search.'%')
            ->join('b.userwishes', 'u')
            ->andWhere("u.id = :userId")
            ->setParameter("userId", $userId)
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function getUserWishBooksByAuthor($search, $userId)
    {
        return $query = $this->getEntityManager()
            ->getRepository('AppBundle:Book')
            ->createQueryBuilder('b')
            ->join('b.authors', 'a')
            ->orWhere("a.authorName like :search")
            ->setParameter("search", '%'.$search.'%')
            ->join('b.userwishes', 'u')
            ->andWhere("u.id = :userId")
            ->setParameter("userId", $userId)
            ->getQuery()
            ->getResult()
        ;
    }
}
