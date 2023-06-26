<?php

namespace App\Repository;

use App\Entity\Idpidn;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Idpidn|null find($id, $lockMode = null, $lockVersion = null)
 * @method Idpidn|null findOneBy(array $criteria, array $orderBy = null)
 * @method Idpidn[]    findAll()
 * @method Idpidn[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IdpidnRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Idpidn::class);
    }

    // /**
    //  * @return Idpidn[] Returns an array of Idpidn objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Idpidn
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
