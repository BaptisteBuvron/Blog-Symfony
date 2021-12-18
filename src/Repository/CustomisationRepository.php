<?php

namespace App\Repository;

use App\Entity\Customisation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Customisation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customisation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customisation[]    findAll()
 * @method Customisation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomisationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customisation::class);
    }

    // /**
    //  * @return Customisation[] Returns an array of Customisation objects
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
    public function findOneBySomeField($value): ?Customisation
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
