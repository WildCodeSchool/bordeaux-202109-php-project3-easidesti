<?php

namespace App\Repository;

use App\Entity\SchoolLevel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SchoolLevel|null find($id, $lockMode = null, $lockVersion = null)
 * @method SchoolLevel|null findOneBy(array $criteria, array $orderBy = null)
 * @method SchoolLevel[]    findAll()
 * @method SchoolLevel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SchoolLevelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SchoolLevel::class);
    }

    // /**
    //  * @return SchoolLevel[] Returns an array of SchoolLevel objects
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
    public function findOneBySomeField($value): ?SchoolLevel
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
