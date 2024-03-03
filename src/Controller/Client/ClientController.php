<?php

namespace App\Controller\Client;

use App\Entity\TechcareClient;
use App\Form\Client\ClientForm;
use App\Menu\MenuBuilder;
use App\Service\Client\ClientService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    private ClientService $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    #[Route('/client/list', name: 'app_client_list')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_COMPANY');

        $userConnected = $this->getUser();
        $datas = $this->clientService->getClientList($userConnected);

        return $this->render('employee/client/index.html.twig', [
            'menuItems' => (new MenuBuilder)->createMainMenu([
                'connected' => true,
                'role' => $this->getUser()->getRoles()[0]
            ]),
            'company' => $this->getUser()->getCompany()->getName(),
            'footerItems' => (new MenuBuilder)->createMainFooter(),
            'controller_name' => 'ClientController',
            'datas' => $datas['datas'],
            'entityProperties' => $datas['entityProperties'],
        ]);
    }

    #[Route('/client/add', name: 'app_client_add', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_COMPANY');
        $client = new TechcareClient();
        $form = $this->createForm(ClientForm::class, $client);
        $form->handleRequest($request);

        $bool = $this->clientService->addClient($client, $this->getUser(), $form);

        if ($bool) {
            $this->addFlash('success', 'Nouveau client ajouté avec succès !');
            return $this->redirectToRoute('app_client_list');
        } else {
            return $this->render('employee/client/new.html.twig', [
                'menuItems' => (new MenuBuilder)->createMainMenu([
                    'connected' => true,
                    'role' => $this->getUser()->getRoles()[0]
                ]),
                'footerItems' => (new MenuBuilder)->createMainFooter(),
                'company' => $this->getUser()->getCompany()->getName(),
                'controller_name' => 'ClientController',
                'title' => 'Ajouter un client',
                'form' => $form->createView(),
            ]);
        }

    }

    #[Route('/client/edit/{id}', name: 'app_client_edit', methods: ['GET', 'POST'])]
    public function update(Request $request, TechcareClient $client): Response
    {
        $this->denyAccessUnlessGranted('ROLE_COMPANY');
        if ($client->getCompany() !== $this->getUser()->getCompany()) {
            return $this->redirectToRoute('app_client_list');
        }
        $form = $this->createForm(ClientForm::class, $client);
        $form->handleRequest($request);

        $bool = $this->clientService->updateClient($client, $form, $this->getUser());
        if ($bool) {
            $this->addFlash('success', 'Client modifié avec succès !');
            return $this->redirectToRoute('app_client_list');
        } else {
            return $this->render('employee/client/edit.html.twig', [
                'menuItems' => (new MenuBuilder)->createMainMenu([
                    'connected' => true,
                    'role' => $this->getUser()->getRoles()[0]
                ]),
                'company' => $this->getUser()->getCompany()->getName(),
                'footerItems' => (new MenuBuilder)->createMainFooter(),
                'controller_name' => 'ClientController',
                'title' => 'Modification d\'un client',
                'form' => $form->createView(),
            ]);
        }
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
            $this->addFlash('success', 'Client supprimé avec succès !');
        }
        return $this->redirectToRoute('app_client_list', [], Response::HTTP_SEE_OTHER);
    }
}
