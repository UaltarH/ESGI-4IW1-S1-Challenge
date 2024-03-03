<?php

namespace App\Service\Payement;

use App\Repository\TechcarePaymentRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use App\Enum\InvoiceStatus;
use App\Enum\QuotationStatus;

class PayementService
{
    private $paymentRepository;
    private $entityManager;

    public function __construct(
        TechcarePaymentRepository $paymentRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->paymentRepository = $paymentRepository;
        $this->entityManager = $entityManager;
    }

    public function getPayements($userConnected)
    {
        $company = $userConnected->getCompany();
        $clientsCompany = $company->getClient();
        $payements = [];
        foreach ($clientsCompany as $client) {
            $payements = array_merge($payements, $client->getPayments()->toArray());
        }

        // sort by date
        usort($payements, function ($a, $b) {
            $dateA = $a->getDate() ?? new DateTimeImmutable('0000-00-00');
            $dateB = $b->getDate() ?? new DateTimeImmutable('0000-00-00');

            return $dateB <=> $dateA;
        });

        $payementsMapped = array_map(function ($payement) {
            return [
                'payment_number' => $payement->getPaymentNumber(),
                'status' => $payement->getInvoice()->getStatus() ?? 'En attente',
                'client' => $payement->getClient()->getFirstname() . ' ' . $payement->getClient()->getLastname(),
                'invoice' => $payement->getInvoice()->getInvoiceNumber(),
                'amount' => $payement->getAmount(),
                'date' => $payement->getDate()->format('d/m/Y H:i'),
            ];
        }, $payements);

        $entityProperties = [
            'payment_number' => 'Numéro de paiement',
            'status' => 'Statut',
            'client' => 'Client',
            'invoice' => 'Numéro de facture',
            'amount' => 'Montant',
            'date' => 'Date',
        ];
        return [
            'datas' => $payementsMapped,
            'entityProperties' => $entityProperties,
        ];

        return $payementsMapped;
    }

    public function action(string $token)
    {
        $payement = $this->paymentRepository->findOneBy(['token' => $token]);

        if ($payement === null) {
            return '';
        } else {
            $payement->setDate(new DateTimeImmutable());
            $payement->setToken(null);

            $invoice = $payement->getInvoice();
            $invoice->setStatus(InvoiceStatus::paid->value);

            $quotation = $payement->getQuotation();
            $quotation->setStatus(QuotationStatus::paid->value);

            $this->entityManager->flush();
            return $invoice->getInvoiceNumber();
        }
    }
}
