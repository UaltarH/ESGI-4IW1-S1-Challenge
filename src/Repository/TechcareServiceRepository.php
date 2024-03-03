<?php

namespace App\Repository;

use App\Entity\TechcareService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TechcareService>
 *
 * @method TechcareService|null find($id, $lockMode = null, $lockVersion = null)
 * @method TechcareService|null findOneBy(array $criteria, array $orderBy = null)
 * @method TechcareService[]    findAll()
 * @method TechcareService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TechcareServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TechcareService::class);
    }

//    /**
//     * @return TechcareService[] Returns an array of TechcareService objects
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

//    public function findOneBySomeField($value): ?TechcareService
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
