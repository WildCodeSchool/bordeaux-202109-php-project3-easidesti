<?php

namespace App\Repository;

use App\Entity\Endpoint;
use App\Entity\Game;
use App\Entity\Letter;
use App\Entity\Serie;
use App\Entity\Word;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Serie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Serie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Serie[]    findAll()
 * @method Serie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Serie::class);
    }

    public function countNoEndpoint(Serie $serie): ?int
    {
        return $this->createQueryBuilder('s')
            ->select('count(w.id)')
            ->leftJoin('s.words', 'w')
            ->leftJoin('w.endpoints', 'e')
            ->andWhere('w.serie = :serie')
            ->andWhere('e.position IS NULL')
            ->setParameter('serie', $serie)
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    public function findSerieWork(Letter $letter, int $level, Game $lastGame)
    {
        return $this->createQueryBuilder('s')
            ->where('s.letter = :letter')
            ->andWhere('s.level = :level')
            ->andWhere('s.id != :lastGame')
            ->setParameter('letter', $letter)
            ->setParameter('level', $level)
            ->setParameter('lastGame', $lastGame)
            ->getQuery()
            ->getResult()
            ;
    }
    // /**
    //  * @return Serie[] Returns an array of Serie objects
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
    public function findOneBySomeField($value): ?Serie
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
