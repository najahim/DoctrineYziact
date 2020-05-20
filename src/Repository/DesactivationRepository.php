<?php

namespace App\Repository;

use App\Entity\Desactivation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Desactivation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Desactivation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Desactivation[]    findAll()
 * @method Desactivation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DesactivationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Desactivation::class);
    }



     /**
      * @return Desactivation[] Returns an array of Desactivation objects
      */

    public function findByBorne($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.borne = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }



    /**
     * @return Desactivation[] Returns an array of Desactivation objects
     */

    public function findByBorneLast($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.borne = :val')
            ->setParameter('val', $value)
            ->orderBy('d.date', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Desactivation[] Returns an array of Desactivation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Desactivation
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
