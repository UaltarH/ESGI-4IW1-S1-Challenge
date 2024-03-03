<?php

namespace App\Repository;

use App\Entity\TechcarePayment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TechcarePayment>
 *
 * @method TechcarePayment|null find($id, $lockMode = null, $lockVersion = null)
 * @method TechcarePayment|null findOneBy(array $criteria, array $orderBy = null)
 * @method TechcarePayment[]    findAll()
 * @method TechcarePayment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TechcarePaymentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TechcarePayment::class);
    }

//    /**
//     * @return TechcarePayment[] Returns an array of TechcarePayment objects
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

//    public function findOneBySomeField($value): ?TechcarePayment
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
