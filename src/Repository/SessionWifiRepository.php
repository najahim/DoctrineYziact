<?php

namespace App\Repository;

use App\Entity\SessionWifi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use DoctrineExtensions\Query\Postgresql\DatePart;


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

    //nombre de peripherique par borne
    public function nbDeviceByBorne($value){
        return $this->createQueryBuilder('s')
            ->select('count(s.id)')
            ->where('s.borne = :valId')
            ->setParameter('valId',$value)
            ->getQuery()
            ->getResult();

    }
    //nombre d'utilisateurs  par borne
    public function nbUsersByBorne($value){
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT count(distinct(u))
        FROM App\Entity\SessionWifi s
        INNER JOIN s.peripherique p
        INNER JOIN p.utilisateur u
        WHERE s.borne = :id'
        )->setParameter('id', $value);
          return $query->getResult();

    }
    //nombre de peripherique par borne par jour
    public function nbDeviceByBornePerDay($value){

        return $this->createQueryBuilder('s')
            ->select("count(s.id) as count,SUBSTRING(CONCAT(s.date_debut,''),1,11)as day")
            ->where('s.borne = :valId')
            ->setParameter('valId',$value)
            ->groupBy('day')
            ->getQuery()
            ->getResult();

    }
    //nombre de peripherique par borne par mois
    public function nbDeviceByBornePerMonth($value){

        return $this->createQueryBuilder('s')
            ->select("count(s.id) as count,SUBSTRING(CONCAT(s.date_debut,''),1,7)as month")
            ->where('s.borne = :valId')
            ->setParameter('valId',$value)
            ->groupBy('month')
            ->getQuery()
            ->getResult();

    }

    //nombre de peripherique par borne par an
    public function nbDeviceByBornePerYear($value){

        return $this->createQueryBuilder('s')
            ->select("count(s.id) as count,SUBSTRING(CONCAT(s.date_debut,''),1,4)as year")
            ->where('s.borne = :valId')
            ->setParameter('valId',$value)
            ->groupBy('year')
            ->getQuery()
            ->getResult();

    }

    public function adresseMacDevices($value){

        return $this->createQueryBuilder('s')
            ->select('s.id')
            ->where('s.borne = :valId')
            ->setParameter('valId',$value)
            ->getQuery()
            ->getResult();

    }

    public function findLast($value){

        return $this->createQueryBuilder('s')
            ->select("s")
            ->where('s.peripherique = :valId')
            ->setParameter('valId',$value)
            ->orderBy('s.id','DESC')
            ->getQuery()
            ->getResult();

    }

    public function findLastOpen($value){

        return $this->createQueryBuilder('s')
            ->select("s")
            ->where('s.peripherique = :valId')
            ->setParameter('valId',$value)
            ->andWhere("s.date_fin is NULL")
            ->orderBy('s.id','DESC')
            ->getQuery()
            ->getResult();

    }

    public function findByBorneDate($id,$date){

        return $this->createQueryBuilder('s')
            ->select("s.borne,s.date_fin,SUBSTRING(CONCAT(s.date_debut,''),1,11) as date")
            ->where("date = :valDate")
            ->setParameter('valDate',$date)
            ->andWhere("s.borne = :valId")
            ->setParameter('valId',$id)
            ->andWhere("s.date_fin is NULL")

            ->getQuery()
            ->getResult();

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
