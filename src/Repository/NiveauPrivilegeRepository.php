<?php

namespace App\Repository;

use App\Entity\NiveauPrivilege;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method NiveauPrivilege|null find($id, $lockMode = null, $lockVersion = null)
 * @method NiveauPrivilege|null findOneBy(array $criteria, array $orderBy = null)
 * @method NiveauPrivilege[]    findAll()
 * @method NiveauPrivilege[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NiveauPrivilegeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NiveauPrivilege::class);
    }

    // /**
    //  * @return NiveauPrivilege[] Returns an array of NiveauPrivilege objects
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
    public function findOneBySomeField($value): ?NiveauPrivilege
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
