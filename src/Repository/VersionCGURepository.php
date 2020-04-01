<?php

namespace App\Repository;

use App\Entity\VersionCGU;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method VersionCGU|null find($id, $lockMode = null, $lockVersion = null)
 * @method VersionCGU|null findOneBy(array $criteria, array $orderBy = null)
 * @method VersionCGU[]    findAll()
 * @method VersionCGU[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VersionCGURepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VersionCGU::class);
    }

    // /**
    //  * @return VersionCGU[] Returns an array of VersionCGU objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VersionCGU
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
