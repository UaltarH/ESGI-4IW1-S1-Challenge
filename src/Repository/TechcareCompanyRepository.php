<?php

namespace App\Repository;

use App\Entity\TechcareCompany;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TechcareCompany>
 *
 * @method TechcareCompany|null find($id, $lockMode = null, $lockVersion = null)
 * @method TechcareCompany|null findOneBy(array $criteria, array $orderBy = null)
 * @method TechcareCompany[]    findAll()
 * @method TechcareCompany[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TechcareCompanyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TechcareCompany::class);
    }

//    /**
//     * @return TechcareCompany[] Returns an array of TechcareCompany objects
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

//    public function findOneBySomeField($value): ?TechcareCompany
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function countCompaniesBetweenPeriod($start, $end): array
    {
        $qb = $this->createQueryBuilder('c');
        $qb->select('c')
            ->where('c.CreatedAt between :start and :end')
            ->setParameter('start', $start)
            ->setParameter('end', $end);
        return $qb->getQuery()->getResult();
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function countCompanies(): int
    {
        $qb = $this->createQueryBuilder('c');
        $qb->select('count(c.id)');
        return $qb->getQuery()->getSingleScalarResult();
    }
}
