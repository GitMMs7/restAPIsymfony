<?php

namespace App\Repository;

use App\Entity\Jezyki;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Jezyki|null find($id, $lockMode = null, $lockVersion = null)
 * @method Jezyki|null findOneBy(array $criteria, array $orderBy = null)
 * @method Jezyki[]    findAll()
 * @method Jezyki[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JezykiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Jezyki::class);
    }

    // /**
    //  * @return Jezyki[] Returns an array of Jezyki objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Jezyki
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
