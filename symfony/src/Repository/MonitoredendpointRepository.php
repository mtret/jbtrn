<?php

namespace App\Repository;

use App\Entity\Monitoredendpoint;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Monitoredendpoint|null find($id, $lockMode = null, $lockVersion = null)
 * @method Monitoredendpoint|null findOneBy(array $criteria, array $orderBy = null)
 * @method Monitoredendpoint[]    findAll()
 * @method Monitoredendpoint[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MonitoredendpointRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Monitoredendpoint::class);
    }

    // /**
    //  * @return Monitoredendpoint[] Returns an array of Monitoredendpoint objects
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
    public function findOneBySomeField($value): ?Monitoredendpoint
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
