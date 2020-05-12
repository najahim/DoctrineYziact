<?php

namespace App\Repository;

use App\Entity\Nouveaute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Nouveaute|null find($id, $lockMode = null, $lockVersion = null)
 * @method Nouveaute|null findOneBy(array $criteria, array $orderBy = null)
 * @method Nouveaute[]    findAll()
 * @method Nouveaute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NouveauteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Nouveaute::class);
    }

    public function findbyType($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.typenouveaute = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
            ;
    }
    // /**
    //  * @return Nouveaute[] Returns an array of Nouveaute objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Nouveaute
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
