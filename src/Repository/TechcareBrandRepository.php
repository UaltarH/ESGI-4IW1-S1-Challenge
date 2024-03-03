<?php

namespace App\Repository;

use App\Entity\TechcareBrand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TechcareBrand>
 *
 * @method TechcareBrand|null find($id, $lockMode = null, $lockVersion = null)
 * @method TechcareBrand|null findOneBy(array $criteria, array $orderBy = null)
 * @method TechcareBrand[]    findAll()
 * @method TechcareBrand[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TechcareBrandRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TechcareBrand::class);
    }

//    /**
//     * @return TechcareBrand[] Returns an array of TechcareBrand objects
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

//    public function findOneBySomeField($value): ?TechcareBrand
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
