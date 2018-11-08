<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use App\Entity\ArticleFormone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ArticleFormoneRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ArticleFormone::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('a')
            ->where('a.something = :value')->setParameter('value', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public static function getListQuantityNotNull(EntityRepository $er){
        $queryBuilder = $er->createQueryBuilder('a');
        $queryBuilder->select('a')
                    ->where('a.quantite > 0');

        return $queryBuilder;
    }
}
