<?php

namespace App\Controller\Quotation;

use App\Repository\TechcareQuotationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Menu\MenuBuilder;
use App\Entity\TechcareQuotation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Faker\Factory;
use App\Service\QuotationService;


class QuotationManagerController extends AbstractController
{
    private QuotationService $quotationService;

    public function __construct(QuotationService $quotationService)
    {
        $this->quotationService = $quotationService;
    }

    #[Route('/quotation/manager', name: 'app_quotation_manager')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
        $this->denyAccessUnlessGranted('ROLE_COMPANY');

        $data = $this->quotationService->manager($this->getUser());

        return $this->render('quotation/index.html.twig', [
            'menuItems' => (new MenuBuilder)->createMainMenu(['connected' => $this->getUser() instanceof UserInterface]),
            'datas' => $data,
            'entityProperties' => [
                'quotation_number' => 'Numéro de devis',
                'client' => 'Client',
                'created_by' => 'Créé par',
                'last_modif' => 'Dernière modification',
                'amount' => 'Montant',
                'status' => 'Statut',
                'actions' => 'Actions',
            ],
        ]);
    }

    #[Route('/quotation/show/{id}', name: 'app_quotation_show')]
    public function show(TechcareQuotation $quotation): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');

        $data = $this->quotationService->showQuotation($quotation);
        $data['menuItems'] = (new MenuBuilder)->createMainMenu(['connected' => $this->getUser() instanceof UserInterface]);

        return $this->render('quotation/show.html.twig', $data);
    }

    #[Route('/quotation/edit/{id}', name: 'app_quotation_edit')]
    public function edit(TechcareQuotation $quotation): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');


        $userConnected = $this->getUser();

        $datas = $this->quotationService->editQuotation($quotation, $userConnected);

        return $this->render('quotation/create_edit.html.twig', [
            'menuItems' => (new MenuBuilder)->createMainMenu(['connected' => $userConnected instanceof UserInterface]),
            'services' => $datas['datas']['services'],
            'productsAndComponents' => $datas['datas']['products'],
            'quotationToEdit' => $datas['quotation'],
            'edit' => true,
            'idQuotation' => $quotation->getId(),
        ]);
    }

    #[Route('/quotation/editpost', name: 'app_quotation_edit_post')]
    public function editPost(Request $request): Response
    {
        $jsonData = json_decode($request->getContent(), true);
        $userConnected = $this->getUser();

        $response = $this->quotationService->editPostQuotation($jsonData, $userConnected);
        $responseJson = json_encode($response);
        return new Response($responseJson, 200, ['Content-Type' => 'application/json']);
    }

    #[Route('/quotation/delete/{id}', name: 'app_quotation_delete', methods: ['POST'])]
    public function delete(Request $request, TechcareQuotation $quotation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $quotation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($quotation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_quotation_manager', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/quotation/create', name: 'app_quotation_create')]
    public function create(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');

        $userConnected = $this->getUser();
        $datas = $this->quotationService->createQuotation($userConnected);

        return $this->render('quotation/create_edit.html.twig', [
            'menuItems' => (new MenuBuilder)->createMainMenu(['connected' => $userConnected instanceof UserInterface]),
            'services' => $datas['services'],
            'clients' => $datas['clients'],
            'productsAndComponents' => $datas['products'],
            'edit' => false,
            'idQuotation' => '',
        ]);
    }

    #[Route('/quotation/create/post', name: 'app_quotation_create_post')]
    public function post(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');

        $faker = Factory::create('fr_FR');
        $jsonData = json_decode($request->getContent(), true);
        $response = $this->quotationService->createPostQuotation($jsonData, $this->getUser());

        $responseJson = json_encode($response);
        return new Response($responseJson, 200, ['Content-Type' => 'application/json']);
    }

    #[Route('/quotation/pdf/{id}', name: 'app_quotation_pdf')]
    public function sendPdfFromManager(TechcareQuotation $quotation)
    {
        $this->quotationService->sendPdf($quotation);

        return $this->redirectToRoute('app_quotation_manager');
    }

    #[Route('/quotation/pdfpost', name: 'app_quotation_pdf_post')]
    public function sendPdfFromClient(Request $request, TechcareQuotationRepository $quotationRepository)
    {
        $jsonData = json_decode($request->getContent(), true);
        $quotation = $quotationRepository->find($jsonData['quotationId']);

        $this->quotationService->sendPdf($quotation);

        $responseJson = json_encode(['status' => 'success']);
        return new Response($responseJson, 200, ['Content-Type' => 'application/json']);
    }

    #[Route('/quotation/accept/{token}', name: 'app_quotation_accept')]
    public function acceptQuotation(string $token): Response
    {
        $response = $this->quotationService->acceptQuotation($token);

        if (array_key_exists('quotationNumber', $response)) {
            return $this->render('quotation/acceptedAndRefused.html.twig', [
                'menuItems' => (new MenuBuilder)->createMainMenu(['connected' => false]),
                'quotationNumber' => $response['quotationNumber'],
                'status' => 'accepted',
            ]);
        } else {
            return $this->render('quotation/acceptedAndRefused.html.twig', [
                'menuItems' => (new MenuBuilder)->createMainMenu(['connected' => false]),
                'status' => 'error',
            ]);
        }
    }

    #[Route('/quotation/refuse/{token}', name: 'app_quotation_refuse')]
    public function refuseQuotation(string $token, EntityManagerInterface $entityManager, TechcareQuotationRepository $quotationRepository): Response
    {
        $response = $this->quotationService->refuseQuotation($token);

        if (array_key_exists('quotationNumber', $response)) {
            return $this->render('quotation/acceptedAndRefused.html.twig', [
                'menuItems' => (new MenuBuilder)->createMainMenu(['connected' => false]),
                'quotationNumber' => $response['quotationNumber'],
                'status' => 'refused',
            ]);
        } else {
            return $this->render('quotation/acceptedAndRefused.html.twig', [
                'menuItems' => (new MenuBuilder)->createMainMenu(['connected' => false]),
                'status' => 'error',
            ]);
        }
    }
}
