<?php

namespace App\Repository;

use App\Entity\Facture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class FactureRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Facture::class);
    }

    public function getLastFacture()
    {
        $result = $this->createQueryBuilder('f')
            ->setMaxResults( 1 )
            ->orderBy('f.date_creation', 'DESC')
            ->getQuery()
            ->getResult();
        return $result;
    }

    public function getLastAvoir()
    {
        $result = $this->createQueryBuilder('f')
            ->where('f.num_avoir IS NOT NULL')
            ->setMaxResults( 1 )
            ->orderBy('f.date_avoir', 'DESC')
            ->getQuery()
            ->getResult();
        return $result;
    }

    public function getFactureByMonth($month, $year)
    {

        $date_month = new \DateTime($year.'-'.$month.'-01 00:00:00');

        $result = $this->createQueryBuilder('f')
            ->where('f.date_creation BETWEEN :first_day AND :last_day')
            ->setParameter('first_day', $date_month->format( 'Y-m-d  H:i:s' ))
            ->setParameter('last_day', $date_month->format( 'Y-m-t  23:59:59' ))
            ->orderBy('f.date_creation', 'ASC')
            ->getQuery()
            ->getResult();
        return $result;
    }
}
