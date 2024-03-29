<?php

namespace App\Repository;

use App\Entity\NazwyPotraw;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NazwyPotraw|null find($id, $lockMode = null, $lockVersion = null)
 * @method NazwyPotraw|null findOneBy(array $criteria, array $orderBy = null)
 * @method NazwyPotraw[]    findAll()
 * @method NazwyPotraw[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NazwyPotrawRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NazwyPotraw::class);
    }

    // /**
    //  * @return NazwyPotraw[] Returns an array of NazwyPotraw objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NazwyPotraw
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
