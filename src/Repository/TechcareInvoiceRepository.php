<?php

namespace App\Repository;

use App\Entity\TechcareInvoice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TechcareInvoice>
 *
 * @method TechcareInvoice|null find($id, $lockMode = null, $lockVersion = null)
 * @method TechcareInvoice|null findOneBy(array $criteria, array $orderBy = null)
 * @method TechcareInvoice[]    findAll()
 * @method TechcareInvoice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TechcareInvoiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TechcareInvoice::class);
    }

//    /**
//     * @return TechcareInvoice[] Returns an array of TechcareInvoice objects
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

//    public function findOneBySomeField($value): ?TechcareInvoice
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
