<?php

namespace App\Repository;

use App\Entity\Log;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @author Omar Makled <omar.makled@gmail.com>
 */
class LogRepository extends ServiceEntityRepository
{
  /**
   * @inheritDoc
   */
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, Log::class);
  }

  /**
   * Get count of logs from given criteria
   *
   * @param array $criteria
   *  $criteria = [
   *    'servicesNames',
   *    'statusCode',
   *    'startDate',
   *    'endDate'
   *  ]
   * @return void
   */
  public function getCount(array $criteria = [])
  {
    $queryBuilder = $this->createQueryBuilder('l');

    if ($service = $criteria['serviceNames']) {
      $service = is_array($service) ? $service : explode(',', $service);

      $queryBuilder
        ->where('l.service IN (:service)')
        ->setParameter('service', $service);
    }

    if ($statusCode = $criteria['statusCode']) {
      $queryBuilder
        ->andWhere('l.request LIKE :statusCode')
        ->setParameter('statusCode', '%' . $statusCode . '%');
    }

    if ($startDate = $criteria['startDate']) {
      $queryBuilder
        ->andWhere('l.date >= :startDate')
        ->setParameter('startDate', $startDate);
    }

    if ($endDate = $criteria['endDate']) {
      $queryBuilder
        ->andWhere('l.date <= :endDate')
        ->setParameter('endDate', $endDate);
    }

    return $queryBuilder->select('count(l.id)')
      ->getQuery()
      ->getSingleScalarResult();
  }
}
