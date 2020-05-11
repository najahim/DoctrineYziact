<?php

namespace App\Repository;

use App\Entity\Borne;
use App\Entity\BorneSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Borne|null find($id, $lockMode = null, $lockVersion = null)
 * @method Borne|null findOneBy(array $criteria, array $orderBy = null)
 * @method Borne[]    findAll()
 * @method Borne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method borne[]    getBornes()
 */
class BorneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Borne::class);
    }

    /**
     * @return Borne[] Returns an array of Borne objects
     */

    public function getBornes()
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.etat = :val')
            ->setParameter('val', '1')

            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllVisible(BorneSearch $search)
    {
        $query = $this->createQueryBuilder('b');
        if ($search->getId()){
            $query=$query->where('b.id = :valid');
            $query=$query->setParameter('valid',$search->getId());
        }
        if ($search->getAdresseMac()){
            $query=$query->andWhere('b.adresse_mac = :valadr');
            $query=$query->setParameter('valadr',$search->getAdresseMac());
        }
        return $query->getQuery()
        ->getResult();
    }

    /**
     * @return Borne[] Returns an array of Borne objects
     */
    public function findByUser($id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT b
        FROM App\Entity\Borne b
        INNER JOIN b.flottes f
        INNER JOIN f.manager m
        WHERE f.manager = :id'
        )->setParameter('id', $id);
        return $query->getResult();
    }
    // /**
    //  * @return Borne[] Returns an array of Borne objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Borne
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
