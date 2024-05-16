<?php

namespace App\Repository;

use App\Entity\Availability;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AvailabilityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Availability::class);
    }

    public function findByDateRange($startDate, $endDate)
    {
        $qb = $this->createQueryBuilder('a')
            ->select('a', 'v')
            ->join('a.vehicle', 'v')
            ->where('a.start_date <= :start_date')
            ->andWhere('a.end_date >= :end_date')
            ->setParameter('start_date', $startDate)
            ->setParameter('end_date', $endDate);
            
        return $qb;
    }
}
