<?php

namespace App\Service;

use App\Entity\TechcareInvoice;
use App\Repository\TechcareQuotationRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Utilities\InvoiceUtils;
use App\Utilities\QuotationUtils;
use DateTimeImmutable;
use Faker\Factory;
use App\Entity\TechcarePayment;
use App\Enum\InvoiceStatus;

class InvoiceService
{
    private EntityManagerInterface $entityManager;
    private Invoiceutils $invoiceUtils;
    private QuotationUtils $quotationUtils;
    private TechcareQuotationRepository $quotationRepository;


    public function __construct(
        QuotationUtils $quotationUtils,
        Invoiceutils $invoiceUtils,
        EntityManagerInterface $entityManager,
        TechcareQuotationRepository $quotationRepository
    ) {
        $this->entityManager = $entityManager;
        $this->invoiceUtils = $invoiceUtils;
        $this->quotationUtils = $quotationUtils;
        $this->quotationRepository = $quotationRepository;
    }

    public function manager($userConnected)
    {
        $company = $userConnected->getCompany();
        $clientsCompany = $company->getClient();
        $invoices = [];
        foreach ($clientsCompany as $client) {
            $invoices = array_merge($invoices, $client->getInvoices()->toArray());
        }

        $invoices = $this->invoiceUtils->sortInvoicesByDate($invoices);

        return $this->invoiceUtils->prepareDataForTable($invoices);
    }

    public function showInvoice(TechcareInvoice $invoice)
    {
        return $this->invoiceUtils->prepareDataForPdfOrPreview($invoice);
    }

    public function editInvoice($invoice, $form)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $invoice->setUpdatedAt(new DateTimeImmutable());
            $this->entityManager->persist($invoice);
            $this->entityManager->flush();

            //send email to client
            $this->invoiceUtils->sendPdfUsingEmail($invoice);
            return true;
        }
        return false;
    }

    public function sendInvoice($invoice)
    {
        $this->invoiceUtils->sendPdfUsingEmail($invoice);
    }

    public function createInvoicePrepare($userConnected)
    {
        $company = $userConnected->getCompany();
        $clientsCompany = $company->getClient();

        $quotations = [];
        foreach ($clientsCompany as $client) {
            $quotations = array_merge($quotations, $this->quotationRepository->findAcceptedQuotationsByClient($client));
        }
        return $this->quotationUtils->sortQuotationsByDate($quotations);
    }

    public function createInvoice($invoice, $form, $userConnected)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $faker = Factory::create('fr_FR');
            $quotationSelected = $invoice->getQuotation();
            $company = $userConnected->getCompany();

            //create payement enity
            $newPayment = new TechcarePayment();
            $newPayment->setAmount($invoice->getAmount());
            $newPayment->setMethod('CREDIT_CARD');
            $newPayment->setClient($quotationSelected->getClient());
            $newPayment->setQuotation($quotationSelected);
            $newPayment->setDate(new DateTimeImmutable());
            $newPayment->setPaymentNumber($faker->uuid());
            $this->entityManager->persist($newPayment);

            $invoice->setCreatedAt(new DateTimeImmutable());
            $invoice->setCreatedBy($userConnected->getFirstname() . ' ' . $userConnected->getLastname());
            $invoice->setUpdatedAt(new DateTimeImmutable());
            $invoice->setUpdatedBy($userConnected->getFirstname() . ' ' . $userConnected->getLastname());
            $invoice->setStatus(InvoiceStatus::not_paid->value);
            $invoice->setInvoiceNumber(date('Y') . '-' . date('m') . '-' . str_replace(' ', '', $company->getName()) . '-' . $faker->uuid());
            $invoice->setClient($quotationSelected->getClient());
            $invoice->setPayment($newPayment);
            $this->entityManager->persist($invoice);

            $this->entityManager->flush();

            //send email to client
            $this->invoiceUtils->sendPdfUsingEmail($invoice);
            return true;
        }
        return false;
    }
}
