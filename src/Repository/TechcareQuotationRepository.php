<?php

namespace App\Repository;

use App\Entity\TechcareClient;
use App\Entity\TechcareQuotation;
use App\Enum\QuotationStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
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

    /**
     * @throws NonUniqueResultException
     */
    public function findByNumber($value): ?TechcareQuotation
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.quotation_number = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }
    public function update(TechcareQuotation $quotation): void
    {
        $this->_em->persist($quotation);
        $this->_em->flush();
    }

    public function findAcceptedQuotationsByClient(TechcareClient $client)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.client = :client')
            ->andWhere('q.status = :status')
            ->setParameter('client', $client)
            ->setParameter('status', QuotationStatus::accepted)
            ->getQuery()
            ->getResult();
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function countQuotations(): int
    {
        $qb = $this->createQueryBuilder('q');
        $qb->select('count(q.id)');
        return $qb->getQuery()->getSingleScalarResult();
    }
}
