<?php

namespace App\Repository;

use App\Entity\TypeOfEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TypeOfEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeOfEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeOfEvent[]    findAll()
 * @method TypeOfEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeOfEventRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TypeOfEvent::class);
    }

//    /**
//     * @return TypeOfEvent[] Returns an array of TypeOfEvent objects
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
    public function findOneBySomeField($value): ?TypeOfEvent
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
