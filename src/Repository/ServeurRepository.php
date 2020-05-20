<?php

namespace App\Repository;

use App\Entity\Serveur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Serveur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Serveur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Serveur[]    findAll()
 * @method Serveur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServeurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Serveur::class);
    }

    //nombre de bornes affectées à chaque serveur selon filtrage(active ou non)
    public function findByCountBorne($value)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT s.id, s.nb_max_borne, count(b) as nb_borne
        FROM App\Entity\Serveur s
        LEFT JOIN s.bornes b
        where s.filtrage = :filtrage
        group by s
        order by count(b) ASC'
        )->setParameter('filtrage', $value);
        return $query->getResult();
    }
    // /**
    //  * @return Serveur[] Returns an array of Serveur objects
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
    public function findOneBySomeField($value): ?Serveur
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
