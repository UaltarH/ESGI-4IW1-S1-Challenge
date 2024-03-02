<?php

namespace App\Controller\Payement;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Menu\MenuBuilder;
use App\Repository\TechcarePaymentRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use App\Enum\InvoiceStatus;
use App\Enum\QuotationStatus;

class PayementController extends AbstractController
{
    #[Route('/payementList', name: 'payement_list')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');

        $company = $this->getUser()->getCompany();
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

        return $this->render('payement/index.html.twig', [
            'datas' => $payementsMapped,
            'menuItems' => (new MenuBuilder)->createMainMenu(['connected' => $this->getUser() instanceof UserInterface]),
            'entityProperties' => [
                'payment_number' => 'Numéro de paiement',
                'status' => 'Statut',
                'client' => 'Client',
                'invoice' => 'Numéro de facture',
                'amount' => 'Montant',
                'date' => 'Date',
            ],
        ]);
    }

    #[Route('/payement/{token}', name: 'payement_action')]
    public function action(string $token, EntityManagerInterface $entityManager, TechcarePaymentRepository $paymentRepository): Response
    {
        $payement = $paymentRepository->findOneBy(['token' => $token]);

        if ($payement === null) {
            return $this->render('payement/action.html.twig', [
                'menuItems' => (new MenuBuilder)->createMainMenu(['connected' => false]),
            ]);
        } else {
            $payement->setDate(new DateTimeImmutable());
            $payement->setToken(null);

            $invoice = $payement->getInvoice();
            $invoice->setStatus(InvoiceStatus::paid->value);

            $quotation = $payement->getQuotation();
            $quotation->setStatus(QuotationStatus::paid->value);

            $entityManager->flush();

            return $this->render('payement/action.html.twig', [
                'menuItems' => (new MenuBuilder)->createMainMenu(['connected' => false]),
                'invoiceName' => $invoice->getInvoiceNumber(),
            ]);
        }
    }
}
