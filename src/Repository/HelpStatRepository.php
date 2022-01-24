<?php

namespace App\Repository;

use App\Entity\HelpStat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HelpStat|null find($id, $lockMode = null, $lockVersion = null)
 * @method HelpStat|null findOneBy(array $criteria, array $orderBy = null)
 * @method HelpStat[]    findAll()
 * @method HelpStat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HelpStatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HelpStat::class);
    }

    // /**
    //  * @return HelpStat[] Returns an array of HelpStat objects
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
    public function findOneBySomeField($value): ?HelpStat
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
