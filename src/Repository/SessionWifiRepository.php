<?php

namespace App\Repository;

use App\Entity\SessionWifi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SessionWifi|null find($id, $lockMode = null, $lockVersion = null)
 * @method SessionWifi|null findOneBy(array $criteria, array $orderBy = null)
 * @method SessionWifi[]    findAll()
 * @method SessionWifi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionWifiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SessionWifi::class);
    }

    // /**
    //  * @return SessionWifi[] Returns an array of SessionWifi objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SessionWifi
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
