<?php

namespace App\Repository;

use App\Entity\TechcareComponent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TechcareComponent>
 *
 * @method TechcareComponent|null find($id, $lockMode = null, $lockVersion = null)
 * @method TechcareComponent|null findOneBy(array $criteria, array $orderBy = null)
 * @method TechcareComponent[]    findAll()
 * @method TechcareComponent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TechcareComponentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TechcareComponent::class);
    }

//    /**
//     * @return TechcareComponent[] Returns an array of TechcareComponent objects
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

//    public function findOneBySomeField($value): ?TechcareComponent
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
