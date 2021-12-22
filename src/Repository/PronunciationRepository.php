<?php

namespace App\Repository;

use App\Entity\Pronunciation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Pronunciation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pronunciation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pronunciation[]    findAll()
 * @method Pronunciation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PronunciationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pronunciation::class);
    }

    // /**
    //  * @return Pronunciation[] Returns an array of Pronunciation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Pronunciation
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
