<?php

namespace App\Controller\Invoice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Menu\MenuBuilder;
use App\Entity\TechcareInvoice;
use App\Service\Invoice\InvoiceManagerService;
use App\Form\Invoice\EditInvoiceType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\Invoice\CreateInvoiceType;

class InvoiceManagerController extends AbstractController
{
    private InvoiceManagerService $invoiceService;

    public function __construct(InvoiceManagerService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    #[Route('/invoice/manager', name: 'invoice_manager')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');

        $userConnected = $this->getUser();

        $invoicesMapped = $this->invoiceService->manager($userConnected);

        return $this->render('employee/invoice/index.html.twig', [
            'menuItems' => (new MenuBuilder)->createMainMenu(['connected' => $userConnected instanceof UserInterface]),
            'footerItems' => (new MenuBuilder)->createMainFooter(),
            'datas' => $invoicesMapped,
            'entityProperties' => [
                'invoice_number' => 'Numéro de facture',
                'client' => 'Client',
                'created_by' => 'Créé par',
                'last_modif' => 'Dernière modification',
                'amount' => 'Montant',
                'status' => 'Statut',
                'actions' => 'Actions',
            ],
        ]);
    }

    #[Route('/invoice/show/{id}', name: 'invoice_show')]
    public function show(TechcareInvoice $invoice): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');

        $data = $this->invoiceService->showInvoice($invoice);

        $data['menuItems'] = (new MenuBuilder)->createMainMenu(['connected' => $this->getUser() instanceof UserInterface]);
        $data['footerItems'] = (new MenuBuilder)->createMainFooter();
        return $this->render('employee/invoice/show.html.twig', $data);
    }

    #[Route('/invoice/edit/{id}', name: 'invoice_update')]
    public function update(Request $request, TechcareInvoice $invoice): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');

        $form = $this->createForm(EditInvoiceType::class, $invoice);
        $form->handleRequest($request);

        $bool = $this->invoiceService->editInvoice($invoice, $form);
        if ($bool) {
            $this->addFlash('success', 'Facture modifiée avec succès !');

            return $this->redirectToRoute('invoice_manager');
        } else {
            return $this->render('employee/invoice/edit.html.twig', [
                'menuItems' => (new MenuBuilder)->createMainMenu(['connected' => $this->getUser() instanceof UserInterface]),
                'footerItems' => (new MenuBuilder)->createMainFooter(),
                'form' => $form->createView(),
            ]);
        }
    }

    #[Route('/invoice/delete/{id}', name: 'invoice_delete')]
    public function delete(TechcareInvoice $invoice, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');

        $entityManager->remove($invoice);
        $entityManager->flush();
        $this->addFlash('success', 'Facture supprimée avec succès !');
        return $this->redirectToRoute('invoice_manager');
    }

    #[Route('/invoice/send/{id}', name: 'invoice_send')]
    public function send(TechcareInvoice $invoice): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
        $this->invoiceService->sendInvoice($invoice);
        $this->addFlash('success', 'Facture envoyée avec succès !');
        return $this->redirectToRoute('invoice_manager');
    }

    #[Route('/invoice/new', name: 'invoice_new')]
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');

        $userConnected = $this->getUser();
        $quotations = $this->invoiceService->createInvoicePrepare($userConnected);

        // Variable used to dynamically change the form field "amount" corresponding to the selected quotation
        // with an associative array, where the key is the id of the quotation and the value is the amount of the quotation.
        $quotationsAmount = [];
        foreach ($quotations as $quotation) {
            $quotationsAmount[(string)$quotation->getId()] = $quotation->getAmount();
        }

        $newInvoice = new TechcareInvoice();
        $form = $this->createForm(CreateInvoiceType::class, $newInvoice, ['quotations' => $quotations]);
        $form->handleRequest($request);

        $bool = $this->invoiceService->createInvoice($newInvoice, $form, $userConnected);

        if ($bool) {
            $this->addFlash('success', 'Nouvelle facture ajoutée avec succès !');
            return $this->redirectToRoute('invoice_manager');
        } else {
            return $this->render('employee/invoice/new.html.twig', [
                'menuItems' => (new MenuBuilder)->createMainMenu(['connected' => $userConnected instanceof UserInterface]),
                'footerItems' => (new MenuBuilder)->createMainFooter(),
                'form' => $form->createView(),
                'quotationsAmount' => $quotationsAmount,
            ]);
        }
    }
}
