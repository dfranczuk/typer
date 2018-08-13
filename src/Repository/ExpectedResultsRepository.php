<?php

namespace App\Repository;

use App\Entity\ExpectedResults;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ExpectedResults|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExpectedResults|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExpectedResults[]    findAll()
 * @method ExpectedResults[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpectedResultsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ExpectedResults::class);
    }

//    /**
//     * @return ExpectedResults[] Returns an array of ExpectedResults objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ExpectedResults
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
