<?php

namespace App\Repository;

use App\Entity\TechcareProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TechcareProduct>
 *
 * @method TechcareProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method TechcareProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method TechcareProduct[]    findAll()
 * @method TechcareProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TechcareProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TechcareProduct::class);
    }

//    /**
//     * @return TechcareProduct[] Returns an array of TechcareProduct objects
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

//    public function findOneBySomeField($value): ?TechcareProduct
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
