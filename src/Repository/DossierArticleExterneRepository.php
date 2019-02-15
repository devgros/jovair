<?php

namespace App\Repository;

use App\Entity\DossierArticleExterne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DossierArticleExterne|null find($id, $lockMode = null, $lockVersion = null)
 * @method DossierArticleExterne|null findOneBy(array $criteria, array $orderBy = null)
 * @method DossierArticleExterne[]    findAll()
 * @method DossierArticleExterne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DossierArticleExterneRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DossierArticleExterne::class);
    }

    // /**
    //  * @return DossierArticleExterne[] Returns an array of DossierArticleExterne objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DossierArticleExterne
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
