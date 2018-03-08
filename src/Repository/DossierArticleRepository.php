<?php

namespace App\Repository;

use App\Entity\DossierArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class DossierArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DossierArticle::class);
    }

    
    public function findOldQte($id)
    {
        $result = $this->createQueryBuilder('d')
            ->where('d.id = :value')->setParameter('value', $id)
            ->getQuery()
            ->getResult();
        return $result[0];
    }
}
