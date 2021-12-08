<?php

namespace App\Repository;

use App\Entity\MuteLetter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MuteLetter|null find($id, $lockMode = null, $lockVersion = null)
 * @method MuteLetter|null findOneBy(array $criteria, array $orderBy = null)
 * @method MuteLetter[]    findAll()
 * @method MuteLetter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MuteLetterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MuteLetter::class);
    }

    // /**
    //  * @return MuteLetter[] Returns an array of MuteLetter objects
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
    public function findOneBySomeField($value): ?MuteLetter
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
