<?php

namespace App\Controller\Client;

use App\Entity\TechcareClient;
use App\Form\Client\ClientForm;
use App\Menu\MenuBuilder;
use App\Repository\TechcareClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    #[Route('/client/list', name: 'app_client_list')]
    public function index(TechcareClientRepository $clientRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_COMPANY');
        $company = $this->getUser()->getCompany();
        $clients = $clientRepository->findBy(['company' => $company]);
        $clientsMap = array_map(function ($client) {
            return [
                'fullName' => $client->getFirstname() . ' ' . $client->getLastname(),
                'email' => $client->getEmail(),
                'billingAddress' => $client->getBillingAddress(),
                'phoneNumber' => $client->getPhoneNumber(),
                'updatedAt' => $client->getUpdatedAt()->format('d/m/Y H:i:s'),
                //                'quotations' => $client->getQuotations()->map(function($quotation) {
                //                    return $quotation->getQuotationNumber();
                //                }),
                //                'invoices' => $client->getInvoices()->map(function($invoice) {
                //                    return $invoice->getInvoiceNumber();
                //                }),
                'actions' => [
                    'update' => [
                        'type' => 'button',
                        'path' => 'app_client_edit',
                        'label' => 'Modifier',
                        'id' => $client->getId(),
                    ],
                    'delete' => [
                        'type' => 'form',
                        'path' => 'app_client_delete',
                        'label' => 'Supprimer',
                        'id' => $client->getId(),
                    ]
                ]
            ];
        }, $clients);

        return $this->render('employee/client/index.html.twig', [
            'menuItems' => (new MenuBuilder)->createMainMenu(['connected' => true]),
            'footerItems' => (new MenuBuilder)->createMainFooter(),
            'controller_name' => 'ClientController',
            'datas' => $clientsMap,
            'title' => 'Gestion des clients',
            'entityProperties' => [
                'fullName' => 'Nom',
                'email' => 'E-mail',
                'billingAddress' => 'Adresse de facturation',
                'phoneNumber' => 'N° de téléphone',
                //                'quotations' => 'Devis',
                //                'invoices' => 'Factures',
                'updatedAt' => 'Dernière modification',
                'actions' => 'Actions'
            ]
        ]);
    }

    #[Route('/client/add', name: 'app_client_add', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_COMPANY');
        $client = new TechcareClient();
        $form = $this->createForm(ClientForm::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $client->setUpdatedBy($this->getUser()->getFirstname() . ' ' . $this->getUser()->getLastname());
            $client->setCreatedBy($this->getUser()->getFirstname() . ' ' . $this->getUser()->getLastname());
            $client->setUpdatedAt(new \DateTimeImmutable());
            $client->setCreatedAt(new \DateTimeImmutable());
            $client->setCompany($this->getUser()->getCompany());

            $entityManager->persist($client);
            $entityManager->flush();
            return $this->redirectToRoute('app_client_list');
        }

        return $this->render('employee/client/new.html.twig', [
            'menuItems' => (new MenuBuilder)->createMainMenu(['connected' => true]),
            'footerItems' => (new MenuBuilder)->createMainFooter(),
            'controller_name' => 'ClientController',
            'title' => 'Ajouter un client',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/client/edit/{id}', name: 'app_client_edit', methods: ['GET', 'POST'])]
    public function update(Request $request, TechcareClient $client, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_COMPANY');
        if ($client->getCompany() !== $this->getUser()->getCompany()) {
            return $this->redirectToRoute('app_client_list');
        }
        $form = $this->createForm(ClientForm::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $client->setUpdatedBy($this->getUser()->getFirstname() . ' ' . $this->getUser()->getLastname());
            $client->setUpdatedAt(new \DateTimeImmutable());
            $entityManager->persist($client);
            $entityManager->flush();
            return $this->redirectToRoute('app_client_list');
        }
        return $this->render('employee/client/edit.html.twig', [
            'menuItems' => (new MenuBuilder)->createMainMenu(['connected' => true]),
            'footerItems' => (new MenuBuilder)->createMainFooter(),
            'controller_name' => 'ClientController',
            'title' => 'Modification d\'un client',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/client/delete/{id}', name: 'app_client_delete', methods: ['POST'])]
    public function delete(Request $request, TechcareClient $client, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_COMPANY');
        if ($client->getCompany() !== $this->getUser()->getCompany()) {
            return $this->redirectToRoute('app_client_list');
        }
        if ($this->isCsrfTokenValid('delete' . $client->getId(), $request->request->get('_token'))) {
            $entityManager->remove($client);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_client_list', [], Response::HTTP_SEE_OTHER);
    }
}
