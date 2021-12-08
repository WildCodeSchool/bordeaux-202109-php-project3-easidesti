<?php

namespace App\Repository;

use App\Entity\EndPoint;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EndPoint|null find($id, $lockMode = null, $lockVersion = null)
 * @method EndPoint|null findOneBy(array $criteria, array $orderBy = null)
 * @method EndPoint[]    findAll()
 * @method EndPoint[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EndPointRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EndPoint::class);
    }

    // /**
    //  * @return EndPoint[] Returns an array of EndPoint objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EndPoint
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
