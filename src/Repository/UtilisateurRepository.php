<?php

namespace App\Repository;

use App\Entity\Utilisateur;
use App\Entity\UtilisateurSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Utilisateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Utilisateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Utilisateur[]    findAll()
 * @method Utilisateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UtilisateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utilisateur::class);
    }


    public function findAllVisible(UtilisateurSearch $search)
    {
        $query = $this->createQueryBuilder('u');
        if ($search->getEmail()){
            $query=$query->where('u.email = :valemail');
            $query=$query->setParameter('valemail',$search->getEmail());
        }
        if ($search->getDate()){
            $query=$query->andWhere("SUBSTRING(CONCAT(u.date_creation,''),1,11) = :valdate");
            $query=$query->setParameter('valdate',$search->getDate());
        }
        if ($search->getValidation()){
            $query=$query->andWhere('u.validation = :valvalide');
            $query=$query->setParameter('valvalide',$search->getValidation());
        }
        return $query->getQuery()
            ->getResult();
    }
    // /**
    //  * @return Utilisateur[] Returns an array of Utilisateur objects
    //  */
    
	
	
	/*
	
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Utilisateur
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
