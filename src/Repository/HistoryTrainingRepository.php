<?php

namespace App\Repository;

use App\Entity\HistoryTraining;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HistoryTraining|null find($id, $lockMode = null, $lockVersion = null)
 * @method HistoryTraining|null findOneBy(array $criteria, array $orderBy = null)
 * @method HistoryTraining[]    findAll()
 * @method HistoryTraining[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoryTrainingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HistoryTraining::class);
    }

    // /**
    //  * @return HistoryTraining[] Returns an array of HistoryTraining objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HistoryTraining
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
