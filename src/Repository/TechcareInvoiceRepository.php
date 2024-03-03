<?php

namespace App\Repository;

use App\Entity\TechcareInvoice;
use App\Entity\TechcareQuotationContent;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
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
    public function findPaidInvoices(DateTime $start, DateTime $end): array
    {
        $qb = $this->createQueryBuilder('i');
        $qb->select('i')
            ->where('i.createdAt between :start and :end')
            ->andWhere('i.payment IS NOT NULL')
            ->orderBy('i.createdAt', 'ASC')
            ->setParameter('start', $start)
            ->setParameter('end', $end);
        return $qb->getQuery()->getResult();
    }

    public function findPaidInvoicesByCompany(string $company, DateTime $start, DateTime $end)
    {
        $qb = $this->createQueryBuilder('i');
        $qb->select('i')
            ->join('i.client', 'cl')
            ->join('cl.company', 'c')
            ->where('c.name = :company')
            ->andWhere('i.createdAt between :start and :end')
            ->andWhere('i.status = :status')
            ->orderBy('i.createdAt', 'ASC')
            ->setParameter('company', $company)
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->setParameter('status', 'PAID');
        return $qb->getQuery()->getResult();
    }
    public function findProductCategorySales(DateTime $start, DateTime $end): array
    {
        $qb = $this->createQueryBuilder('i');
        $qb->select('cat.name, SUM(i.amount) as total')
            ->join(TechcareQuotationContent::class, 'qc', 'WITH', 'qc.quotation = i.quotation')
            ->join('qc.product', 'pr')
            ->join('pr.productCategory', 'cat')
            ->join('i.payment', 'p')
            ->where('i.payment IS NOT NULL')
            ->andWhere('i.createdAt between :start and :end')
            ->groupBy('cat.name')
            ->setParameter('start', $start)
            ->setParameter('end', $end);
        return $qb->getQuery()->getResult();
    }
    public function findProductCategorySalesByCompany(string $company, DateTime $getStartDate, DateTime $param)
    {
        $qb = $this->createQueryBuilder('i');
        $qb->select('cat.name, SUM(i.amount) as total')
            ->join(TechcareQuotationContent::class, 'qc', 'WITH', 'qc.quotation = i.quotation')
            ->join('qc.product', 'pr')
            ->join('pr.productCategory', 'cat')
            ->join('i.payment', 'p')
            ->join('p.client', 'cl')
            ->join('cl.company', 'c')
            ->where('c.name = :company')
            ->andWhere('i.payment IS NOT NULL')
            ->andWhere('i.createdAt between :start and :end')
            ->groupBy('cat.name')
            ->setParameter('company', $company)
            ->setParameter('start', $getStartDate)
            ->setParameter('end', $param);
        return $qb->getQuery()->getResult();
    }
    public function findBrandSales(DateTime $start, DateTime $end ): array
    {
        $qb = $this->createQueryBuilder('i');
        $qb->select('br.name, SUM(i.amount) as total')
            ->join(TechcareQuotationContent::class, 'qc', 'WITH', 'qc.quotation = i.quotation')
            ->join('qc.product', 'pr')
            ->join('pr.brand', 'br')
            ->join('i.payment', 'p')
            ->where('i.payment IS NOT NULL')
            ->andWhere('i.createdAt between :start and :end')
            ->groupBy('br.name')
            ->setParameter('start', $start)
            ->setParameter('end', $end);
        return $qb->getQuery()->getResult();
    }
    public function findBrandSalesByCompany(string $company, DateTime $getStartDate, DateTime $param)
    {
        $qb = $this->createQueryBuilder('i');
        $qb->select('br.name, SUM(i.amount) as total')
            ->join(TechcareQuotationContent::class, 'qc', 'WITH', 'qc.quotation = i.quotation')
            ->join('qc.product', 'pr')
            ->join('pr.brand', 'br')
            ->join('i.payment', 'p')
            ->join('p.client', 'cl')
            ->join('cl.company', 'c')
            ->where('c.name = :company')
            ->andWhere('i.payment IS NOT NULL')
            ->andWhere('i.createdAt between :start and :end')
            ->groupBy('br.name')
            ->setParameter('company', $company)
            ->setParameter('start', $getStartDate)
            ->setParameter('end', $param);
        return $qb->getQuery()->getResult();
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function countInvoices(): int
    {
        $qb = $this->createQueryBuilder('i');
        $qb->select('count(i.id)');
        return $qb->getQuery()->getSingleScalarResult();

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
