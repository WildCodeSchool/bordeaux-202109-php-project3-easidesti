<?php

namespace App\Repository;

use App\Entity\StudyLetter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StudyLetter|null find($id, $lockMode = null, $lockVersion = null)
 * @method StudyLetter|null findOneBy(array $criteria, array $orderBy = null)
 * @method StudyLetter[]    findAll()
 * @method StudyLetter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudyLetterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StudyLetter::class);
    }

    // /**
    //  * @return StudyLetter[] Returns an array of StudyLetter objects
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
    public function findOneBySomeField($value): ?StudyLetter
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
