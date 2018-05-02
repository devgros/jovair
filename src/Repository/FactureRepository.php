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
}
