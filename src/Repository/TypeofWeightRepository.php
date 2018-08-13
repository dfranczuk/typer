<?php

namespace App\Repository;

use App\Entity\TypeofWeight;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TypeofWeight|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeofWeight|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeofWeight[]    findAll()
 * @method TypeofWeight[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeofWeightRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TypeofWeight::class);
    }

//    /**
//     * @return TypeofWeight[] Returns an array of TypeofWeight objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeofWeight
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
