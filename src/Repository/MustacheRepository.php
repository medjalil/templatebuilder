<?php

namespace App\Repository;

use App\Entity\Mustache;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Mustache|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mustache|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mustache[]    findAll()
 * @method Mustache[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MustacheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mustache::class);
    }

    // /**
    //  * @return Mustache[] Returns an array of Mustache objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Mustache
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
