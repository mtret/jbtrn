<?php

namespace App\Repository;

use App\Entity\MonitoredEndpoint;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MonitoredEndpoint|null find($id, $lockMode = null, $lockVersion = null)
 * @method MonitoredEndpoint|null findOneBy(array $criteria, array $orderBy = null)
 * @method MonitoredEndpoint[]    findAll()
 * @method MonitoredEndpoint[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MonitoredEndpointRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MonitoredEndpoint::class);
    }

    // /**
    //  * @return MonitoredEndpoint[] Returns an array of MonitoredEndpoint objects
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
    public function findOneBySomeField($value): ?MonitoredEndpoint
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
