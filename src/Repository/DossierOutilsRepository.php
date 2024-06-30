<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use App\Entity\DossierOutils;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Query\Expr\Join;

class DossierOutilsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DossierOutils::class);
    }

    public static function getListOrderByDateGroupByOutillage(EntityRepository $er){
        $subqueryBuilder = $er->createQueryBuilder('o');
 
        $subquery = $subqueryBuilder->select('MAX(o.date_validite)')
                                    ->where($subqueryBuilder->expr()->gt('o.date_validite', 'CURRENT_TIMESTAMP()'))
                                    ->groupBy('o.outillage');

       $queryBuilder = $er->createQueryBuilder('oc');
        $queryBuilder->select('oc')
                    ->where($queryBuilder->expr()->in('oc.date_validite',$subquery->getDQL()))
                    ->groupBy('oc.outillage');

        return $queryBuilder;
    }
}
