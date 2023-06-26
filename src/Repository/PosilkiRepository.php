<?php

namespace App\Repository;

use App\Entity\Posilki;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Posilki|null find($id, $lockMode = null, $lockVersion = null)
 * @method Posilki|null findOneBy(array $criteria, array $orderBy = null)
 * @method Posilki[]    findAll()
 * @method Posilki[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PosilkiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Posilki::class);
    }

    // /**
    //  * @return Posilki[] Returns an array of Posilki objects
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
    public function findOneBySomeField($value): ?Posilki
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
