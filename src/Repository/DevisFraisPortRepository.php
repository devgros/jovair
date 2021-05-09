<?php

namespace App\Repository;

use App\Entity\DevisFraisPort;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DevisFraisPort|null find($id, $lockMode = null, $lockVersion = null)
 * @method DevisFraisPort|null findOneBy(array $criteria, array $orderBy = null)
 * @method DevisFraisPort[]    findAll()
 * @method DevisFraisPort[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DevisFraisPortRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DevisFraisPort::class);
    }

    // /**
    //  * @return DevisFraisPort[] Returns an array of DevisFraisPort objects
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
    public function findOneBySomeField($value): ?DevisFraisPort
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
