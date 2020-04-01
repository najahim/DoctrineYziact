<?php

namespace App\Repository;

use App\Entity\Flotte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Flotte|null find($id, $lockMode = null, $lockVersion = null)
 * @method Flotte|null findOneBy(array $criteria, array $orderBy = null)
 * @method Flotte[]    findAll()
 * @method Flotte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FlotteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Flotte::class);
    }

    // /**
    //  * @return Flotte[] Returns an array of Flotte objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Flotte
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
