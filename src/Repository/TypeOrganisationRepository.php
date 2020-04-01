<?php

namespace App\Repository;

use App\Entity\TypeOrganisation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TypeOrganisation|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeOrganisation|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeOrganisation[]    findAll()
 * @method TypeOrganisation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeOrganisationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeOrganisation::class);
    }

    // /**
    //  * @return TypeOrganisation[] Returns an array of TypeOrganisation objects
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
    public function findOneBySomeField($value): ?TypeOrganisation
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
