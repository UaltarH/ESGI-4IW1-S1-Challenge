<?php

namespace App\Repository;

use App\Entity\TechcareRole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TechcareRole>
 *
 * @method TechcareRole|null find($id, $lockMode = null, $lockVersion = null)
 * @method TechcareRole|null findOneBy(array $criteria, array $orderBy = null)
 * @method TechcareRole[]    findAll()
 * @method TechcareRole[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TechcareRoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TechcareRole::class);
    }

//    /**
//     * @return TechcareRole[] Returns an array of TechcareRole objects
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

//    public function findOneBySomeField($value): ?TechcareRole
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
