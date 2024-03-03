<?php

namespace App\Repository;

use App\Entity\TechcareQuotationContent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TechcareQuotationContent>
 *
 * @method TechcareQuotationContent|null find($id, $lockMode = null, $lockVersion = null)
 * @method TechcareQuotationContent|null findOneBy(array $criteria, array $orderBy = null)
 * @method TechcareQuotationContent[]    findAll()
 * @method TechcareQuotationContent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TechcareQuotationContentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TechcareQuotationContent::class);
    }

//    /**
//     * @return TechcareQuotationContent[] Returns an array of TechcareQuotationContent objects
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

//    public function findOneBySomeField($value): ?TechcareQuotationContent
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
