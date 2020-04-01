<?php

namespace App\Repository;

use App\Entity\TypeNouveaute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TypeNouveaute|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeNouveaute|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeNouveaute[]    findAll()
 * @method TypeNouveaute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeNouveauteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeNouveaute::class);
    }

    // /**
    //  * @return TypeNouveaute[] Returns an array of TypeNouveaute objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeNouveaute
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
