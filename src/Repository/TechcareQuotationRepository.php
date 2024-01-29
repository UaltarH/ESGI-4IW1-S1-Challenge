<?php

namespace App\Repository;

use App\Entity\TechcareQuotation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TechcareQuotation>
 *
 * @method TechcareQuotation|null find($id, $lockMode = null, $lockVersion = null)
 * @method TechcareQuotation|null findOneBy(array $criteria, array $orderBy = null)
 * @method TechcareQuotation[]    findAll()
 * @method TechcareQuotation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TechcareQuotationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TechcareQuotation::class);
    }

//    /**
//     * @return TechcareQuotation[] Returns an array of TechcareQuotation objects
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

//    public function findOneBySomeField($value): ?TechcareQuotation
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
