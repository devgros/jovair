<?php

namespace App\Repository;

use App\Entity\DevisArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class DevisArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DevisArticle::class);
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
