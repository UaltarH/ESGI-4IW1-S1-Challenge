<?php

namespace App\Repository;

use App\Entity\TechcareClient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TechcareClient>
 *
 * @method TechcareClient|null find($id, $lockMode = null, $lockVersion = null)
 * @method TechcareClient|null findOneBy(array $criteria, array $orderBy = null)
 * @method TechcareClient[]    findAll()
 * @method TechcareClient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TechcareClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TechcareClient::class);
    }

//    /**
//     * @return TechcareClient[] Returns an array of TechcareClient objects
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

//    public function findOneBySomeField($value): ?TechcareClient
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
