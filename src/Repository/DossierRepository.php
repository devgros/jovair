<?php

namespace App\Repository;

use App\Entity\Dossier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class DossierRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Dossier::class);
    }

    public function getLastDossier()
    {
        $result = $this->createQueryBuilder('d')
            ->setMaxResults( 1 )
            ->orderBy('d.date_creation', 'DESC')
            ->getQuery()
            ->getResult();
        return $result;
    }
}
