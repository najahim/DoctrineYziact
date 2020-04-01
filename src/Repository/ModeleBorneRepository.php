<?php

namespace App\Repository;

use App\Entity\ModeleBorne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ModeleBorne|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModeleBorne|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModeleBorne[]    findAll()
 * @method ModeleBorne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModeleBorneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ModeleBorne::class);
    }

    // /**
    //  * @return ModeleBorne[] Returns an array of ModeleBorne objects
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
    public function findOneBySomeField($value): ?ModeleBorne
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
