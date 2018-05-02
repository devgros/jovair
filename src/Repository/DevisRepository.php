<?php

namespace App\Repository;

use App\Entity\Devis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class DevisRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Devis::class);
    }

    public function getLastDevis()
    {
        $result = $this->createQueryBuilder('d')
            ->setMaxResults( 1 )
            ->orderBy('d.date_creation', 'DESC')
            ->getQuery()
            ->getResult();
        return $result;
    }
}
