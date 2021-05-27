<?php

namespace App\Repository;

use App\Entity\DossierFraisPort;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DossierFraisPort|null find($id, $lockMode = null, $lockVersion = null)
 * @method DossierFraisPort|null findOneBy(array $criteria, array $orderBy = null)
 * @method DossierFraisPort[]    findAll()
 * @method DossierFraisPort[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DossierFraisPortRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DossierFraisPort::class);
    }

    // /**
    //  * @return DossierFraisPort[] Returns an array of DossierFraisPort objects
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
    public function findOneBySomeField($value): ?DossierFraisPort
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
