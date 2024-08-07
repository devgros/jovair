<?php

namespace App\Repository;

use App\Entity\FactureAcompte;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<FactureAcompte>
 *
 * @method FactureAcompte|null find($id, $lockMode = null, $lockVersion = null)
 * @method FactureAcompte|null findOneBy(array $criteria, array $orderBy = null)
 * @method FactureAcompte[]    findAll()
 * @method FactureAcompte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FactureAcompteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FactureAcompte::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(FactureAcompte $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(FactureAcompte $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return FactureAcompte[] Returns an array of FactureAcompte objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FactureAcompte
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
