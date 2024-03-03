<?php

namespace App\Utilities;

use DateTimeImmutable;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Utilities\PdfUtils;
use App\Utilities\EmailUtils;
use App\Utilities\QuotationUtils;
use Twig\Environment;
use App\Enum\InvoiceStatus;

class InvoiceUtils
{
    private UrlGeneratorInterface $router;
    private EntityManagerInterface $entityManager;
    private PdfUtils $PdfUtils;
    private EmailUtils $emailUtils;
    private QuotationUtils $quotationUtils;
    private Environment $twig;

    public function __construct(
        UrlGeneratorInterface $router,
        EntityManagerInterface $entityManager,
        PdfUtils $PdfUtils,
        EmailUtils $emailUtils,
        Environment $twig,
        QuotationUtils $quotationUtils
    ) {
        $this->router = $router;
        $this->entityManager = $entityManager;
        $this->PdfUtils = $PdfUtils;
        $this->emailUtils = $emailUtils;
        $this->twig = $twig;
        $this->quotationUtils = $quotationUtils;
    }

    public function sortInvoicesByDate($invoices)
    {
        usort($invoices, function ($a, $b) {
            $updatedAtA = $a->getUpdatedAt() ?? new DateTimeImmutable('0000-00-00');
            $updatedAtB = $b->getUpdatedAt() ?? new DateTimeImmutable('0000-00-00');

            return $updatedAtB <=> $updatedAtA;
        });

        return $invoices;
    }

    public function prepareDataForTable($invoices)
    {
        return array_map(function ($invoice) {
            //get date last update if null get date creation
            $date = $invoice->getUpdatedAt() ?? $invoice->getCreatedAt();
            $date = $date->format('d/m/Y H:i');
            $object = [
                'invoice_number' => $invoice->getInvoiceNumber(),
                'client' => $invoice->getClient()->getFirstname() . ' ' . $invoice->getClient()->getLastname(),
                'created_by' => $invoice->getCreatedBy(),
                'last_modif' => $date,
                'amount' => $invoice->getAmount(),
                'status' => $invoice->getStatusName(),
                'actions' => [
                    'show' => [
                        'type' => 'button',
                        'path' => 'invoice_show',
                        'label' => 'Voir',
                        'id' => $invoice->getId(),
                    ],
                    'send' => [
                        'type' => 'button',
                        'path' => 'invoice_send',
                        'label' => 'Envoyer',
                        'id' => $invoice->getId(),
                    ],
                ]
            ];
            //add action edit only for status not paid
            if ($invoice->getStatus() !== 'PAID') {
                $object['actions']['update'] = [
                    'type' => 'button',
                    'path' => 'invoice_update',
                    'label' => 'Modifier',
                    'id' => $invoice->getId(),
                ];
                $object['actions']['delete'] = [
                    'type' => 'button',
                    'deleteStyle' => '****',
                    'path' => 'invoice_delete',
                    'label' => 'Supprimer',
                    'id' => $invoice->getId(),
                ];
            }
            return $object;
        }, $invoices);
    }

    public function prepareDataForPdfOrPreview($invoice)
    {
        $data = [];
        $data['quotation'] = $this->quotationUtils->prepareDataForPdfOrPreview($invoice->getQuotation());
        $data['invoice_number'] = $invoice->getInvoiceNumber();
        $data['invoice_date'] = $invoice->getCreatedAt()->format('d/m/Y');
        $data['invoice_amount'] = $invoice->getAmount();
        return $data;
    }

    public function sendPdfUsingEmail($invoice)
    {
        $urlOrTextMessage = '';
        if ($invoice->getStatus() === InvoiceStatus::paid->value) {
            $htmlContent = '<p>Votre facture a deja été payée</p>';
            $urlOrTextMessage = 'Votre facture a deja été payée';
        } else {
            $invoice->getPayment()->generateToken();
            $payementToken = $invoice->getPayment()->getToken();
            $acceptUrl = $this->router->generate('payement_action', ['token' => $payementToken], UrlGeneratorInterface::ABSOLUTE_URL);
            $htmlContent = '<p>Veuillez cliquer sur le lien ci-dessous pour payer votre facture :</p><br><a href="' . $acceptUrl . '">Payer</a> <br>';

            $urlOrTextMessage = $acceptUrl;
        }

        $this->entityManager->flush();

        $clientEmail = $invoice->getClient()->getEmail();
        $data = $this->prepareDataForPdfOrPreview($invoice);
        $html =  $this->twig->render('pdfTemplates/invoice.html.twig', $data);
        $contentPdf = $this->PdfUtils->generatePdfFile($html);


        //brevo
        $clientFullName = $invoice->getClient()->getFirstname() . ' ' . $invoice->getClient()->getLastname();
        $dateInvoice = $invoice->getCreatedAt()->format('d/m/Y');
        $companyName = $invoice->getClient()->getCompany()->getName();
        $base64 = base64_encode($contentPdf);
        $invoiceName = $invoice->getInvoiceNumber() . '.pdf';


        $this->emailUtils->sendEmailForInvoiceUsingBrevo(
            "admin",
            "admin@techcare.com",
            $clientEmail,
            $clientFullName,
            $dateInvoice,
            $companyName,
            $base64,
            $invoiceName,
            $urlOrTextMessage,
        );


        $this->emailUtils->sendEmailWithPdf('subject', $htmlContent, 'mail@gmail.com', $clientEmail, $contentPdf, $data['invoice_number']);
    }
}
