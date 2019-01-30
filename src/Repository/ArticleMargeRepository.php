<?php

namespace App\Repository;

use App\Entity\ArticleMarge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ArticleMarge|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArticleMarge|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArticleMarge[]    findAll()
 * @method ArticleMarge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleMargeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ArticleMarge::class);
    }

    // /**
    //  * @return ArticleMarge[] Returns an array of ArticleMarge objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ArticleMarge
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
