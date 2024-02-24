<?php

namespace App\Repository;

use App\Entity\TechcareProductComponentPrice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TechcareProductComponentPrice>
 *
 * @method TechcareProductComponentPrice|null find($id, $lockMode = null, $lockVersion = null)
 * @method TechcareProductComponentPrice|null findOneBy(array $criteria, array $orderBy = null)
 * @method TechcareProductComponentPrice[]    findAll()
 * @method TechcareProductComponentPrice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TechcareProductComponentPriceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TechcareProductComponentPrice::class);
    }

//    /**
//     * @return TechcareProductComponentPrice[] Returns an array of TechcareProductComponentPrice objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TechcareProductComponentPrice
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
