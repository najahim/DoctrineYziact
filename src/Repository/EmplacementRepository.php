<?php

namespace App\Repository;

use App\Entity\Emplacement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Emplacement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Emplacement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Emplacement[]    findAll()
 * @method Emplacement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmplacementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Emplacement::class);
    }


    //ordre decroissant des emplacements
     /**
      * @return Emplacement[] Returns an array of Emplacement objects
      */

    public function findByOrder()
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Emplacement[] Returns an array of Emplacement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Emplacement
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
