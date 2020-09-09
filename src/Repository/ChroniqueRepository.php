<?php

namespace App\Repository;

use App\Entity\Chronique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Chronique|null find($id, $lockMode = null, $lockVersion = null)
 * @method Chronique|null findOneBy(array $criteria, array $orderBy = null)
 * @method Chronique[]    findAll()
 * @method Chronique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChroniqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chronique::class);
    }

    // /**
    //  * @return Chronique[] Returns an array of Chronique objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Chronique
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
