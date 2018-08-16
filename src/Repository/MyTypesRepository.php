<?php

namespace App\Repository;

use App\Entity\MyTypes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MyTypes|null find($id, $lockMode = null, $lockVersion = null)
 * @method MyTypes|null findOneBy(array $criteria, array $orderBy = null)
 * @method MyTypes[]    findAll()
 * @method MyTypes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MyTypesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MyTypes::class);
    }

//    /**
//     * @return MyTypes[] Returns an array of MyTypes objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MyTypes
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
