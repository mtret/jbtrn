<?php

namespace App\Repository;

use App\Entity\MonitoringResult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MonitoringResult|null find($id, $lockMode = null, $lockVersion = null)
 * @method MonitoringResult|null findOneBy(array $criteria, array $orderBy = null)
 * @method MonitoringResult[]    findAll()
 * @method MonitoringResult[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MonitoringResultRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MonitoringResult::class);
    }

}
