<?php

namespace App\Repository;

use App\Entity\TechcareProductCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TechcareProductCategory>
 *
 * @method TechcareProductCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method TechcareProductCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method TechcareProductCategory[]    findAll()
 * @method TechcareProductCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TechcareProductCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TechcareProductCategory::class);
    }

//    /**
//     * @return TechcareProductCategory[] Returns an array of TechcareProductCategory objects
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

//    public function findOneBySomeField($value): ?TechcareProductCategory
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
