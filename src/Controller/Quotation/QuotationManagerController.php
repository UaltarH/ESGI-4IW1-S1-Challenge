<?php

namespace App\Controller\Quotation;

use App\Repository\TechcareQuotationRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Menu\MenuBuilder;
use App\Entity\TechcareQuotation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Service\Quotation\QuotationManagerService;
use Symfony\Component\HttpFoundation\JsonResponse;

class QuotationManagerController extends AbstractController
{
    private QuotationManagerService $quotationService;

    public function __construct(QuotationManagerService $quotationService)
    {
        $this->quotationService = $quotationService;
    }

    #[Route('/quotation/manager', name: 'app_quotation_manager')]
    public function index(): Response | Exception
    {
        if (!$this->isGranted('ROLE_COMPANY') && !$this->isGranted('ROLE_OWNER_COMPANY') && !$this->isGranted('ROLE_ACCOUNTANT')) {
            return $this->createAccessDeniedException("Vous n'avez pas les droits pour accéder à cette page.");
        }

        $data = $this->quotationService->manager($this->getUser());

        return $this->render('employee/quotation/index.html.twig', [
            'menuItems' => (new MenuBuilder)->createMainMenu([
                'connected' => $this->getUser() instanceof UserInterface,
                'role' => $this->getUser()->getRoles()[0],
            ]),
            'footerItems' => (new MenuBuilder)->createMainFooter(),
            'company' => $this->getUser()->getCompany()->getName(),
            'datas' => $data['datas'],
            'entityProperties' => $data['entityProperties'],
        ]);
    }

    #[Route('/quotation/show/{id}', name: 'app_quotation_show')]
    public function show(TechcareQuotation $quotation): Response | Exception
    {
        if (!$this->isGranted('ROLE_COMPANY') && !$this->isGranted('ROLE_OWNER_COMPANY') && !$this->isGranted('ROLE_ACCOUNTANT')) {
            return $this->createAccessDeniedException("Vous n'avez pas les droits pour accéder à ce devis");
        }
        if ($quotation->getClient()->getCompany() !== $this->getUser()->getCompany()) {
            return $this->createAccessDeniedException("Vous n'avez pas les droits pour accéder à ce devis");
        }

        $connected = $this->getUser() instanceof UserInterface;

        $data = $this->quotationService->showQuotation($quotation);
        $data['menuItems'] = (new MenuBuilder)->createMainMenu([
            'connected' => $connected,
            'role' => $this->getUser()->getRoles()[0],
        ]);
        $data['footerItems'] = (new MenuBuilder)->createMainFooter();
        if ($connected) {
            $data['company'] = $this->getUser()->getCompany()->getName();
        }


        return $this->render('employee/quotation/show.html.twig', $data);
    }

    #[Route('/quotation/edit/{id}', name: 'app_quotation_edit')]
    public function edit(TechcareQuotation $quotation): Response | Exception
    {
        if (!$this->isGranted('ROLE_COMPANY') && !$this->isGranted('ROLE_OWNER_COMPANY') && !$this->isGranted('ROLE_ACCOUNTANT')) {
            return $this->createAccessDeniedException("Vous n'avez pas les droits pour modifier ce devis.");
        }
        if ($quotation->getClient()->getCompany() !== $this->getUser()->getCompany()) {
            return $this->createAccessDeniedException("Vous n'avez pas les droits pour modifier ce devis.");
        }

        $userConnected = $this->getUser();

        $datas = $this->quotationService->editQuotation($quotation, $userConnected);

        return $this->render('employee/quotation/create_edit.html.twig', [
            'menuItems' => (new MenuBuilder)->createMainMenu([
                'connected' => $userConnected instanceof UserInterface,
                'role' => $userConnected->getRoles()[0],
            ]),
            'footerItems' => (new MenuBuilder)->createMainFooter(),
            'company' => $userConnected->getCompany()->getName(),
            'services' => $datas['datas']['services'],
            'productsAndComponents' => $datas['datas']['products'],
            'quotationToEdit' => $datas['quotation'],
            'edit' => true,
            'idQuotation' => $quotation->getId(),
            'user' => $userConnected->getId(),
        ]);
    }

    #[Route('/quotation/editpost', name: 'app_quotation_edit_post')]
    public function editPost(Request $request): Response
    {
        $quotationData = $request->request->get('quotationData');
        $quotationArray = json_decode($quotationData, true);
        $userConnected = $this->getUser();

        $this->quotationService->editPostQuotation($quotationArray, $userConnected);

        $this->addFlash('success', 'Votre devis a bien été modifié et envoyer à votre client !');
        return $this->redirectToRoute('app_quotation_manager');
    }

    #[Route('/quotation/delete/{id}', name: 'app_quotation_delete', methods: ['POST'])]
    public function delete(Request $request, TechcareQuotation $quotation, EntityManagerInterface $entityManager): Response | Exception
    {
        if (!$this->isGranted('ROLE_COMPANY') && !$this->isGranted('ROLE_OWNER_COMPANY') && !$this->isGranted('ROLE_ACCOUNTANT')) {
            return $this->createAccessDeniedException("Vous n'avez pas les droits pour supprimer ce devis.");
        }
        if ($quotation->getClient()->getCompany() !== $this->getUser()->getCompany()) {
            return $this->createAccessDeniedException("Vous n'avez pas les droits pour supprimer ce devis.");
        }
        if ($this->isCsrfTokenValid('delete' . $quotation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($quotation);
            $entityManager->flush();
        }
        $this->addFlash('success', 'Devis supprimé avec succès !');
        return $this->redirectToRoute('app_quotation_manager', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/quotation/create', name: 'app_quotation_create')]
    public function create(): Response | Exception
    {
        if (!$this->isGranted('ROLE_COMPANY') && !$this->isGranted('ROLE_OWNER_COMPANY') && !$this->isGranted('ROLE_ACCOUNTANT')) {
            return $this->createAccessDeniedException("Vous n'avez pas les droits pour accéder à cette page.");
        }

        $userConnected = $this->getUser();
        $datas = $this->quotationService->createQuotation($userConnected);
        return $this->render('employee/quotation/create_edit.html.twig', [
            'menuItems' => (new MenuBuilder)->createMainMenu([
                'connected' => $userConnected instanceof UserInterface,
                'role' => $userConnected->getRoles()[0],
            ]),
            'footerItems' => (new MenuBuilder)->createMainFooter(),
            'company' => $userConnected->getCompany()->getName(),
            'services' => $datas['services'],
            'clients' => $datas['clients'],
            'productsAndComponents' => $datas['products'],
            'edit' => false,
            'idQuotation' => '',
            'user' => (string)$userConnected->getId(),
        ]);
    }

    #[Route('/quotation/create/post', name: 'app_quotation_create_post')]
    public function post(Request $request): Response
    {
        $quotationData = $request->request->get('quotationData');
        $quotationArray = json_decode($quotationData, true);
        $this->quotationService->createPostQuotation($quotationArray, $this->getUser());

        $this->addFlash('success', 'Votre devis a bien été créer et envoyer à votre client !');
        return $this->redirectToRoute('app_quotation_manager');
    }

    #[Route('/quotation/pdf/{id}', name: 'app_quotation_pdf')]
    public function sendPdfFromManager(TechcareQuotation $quotation)
    {
        $this->quotationService->sendPdf($quotation);
        $this->addFlash('success', 'Le devis a bien été envoyé !');
        return $this->redirectToRoute('app_quotation_manager');
    }

    #[Route('/quotation/accept/{token}', name: 'app_quotation_accept')]
    public function acceptQuotation(string $token): Response
    {
        $response = $this->quotationService->acceptQuotation($token);

        if (array_key_exists('quotationNumber', $response)) {
            return $this->render('employee/quotation/acceptedAndRefused.html.twig', [
                'menuItems' => (new MenuBuilder)->createMainMenu(['connected' => false]),
                'footerItems' => (new MenuBuilder)->createMainFooter(),
                'quotationNumber' => $response['quotationNumber'],
                'status' => 'accepted',
            ]);
        } else {
            return $this->render('employee/quotation/acceptedAndRefused.html.twig', [
                'menuItems' => (new MenuBuilder)->createMainMenu(['connected' => false]),
                'footerItems' => (new MenuBuilder)->createMainFooter(),
                'status' => 'error',
            ]);
        }
    }

    #[Route('/quotation/refuse/{token}', name: 'app_quotation_refuse')]
    public function refuseQuotation(string $token): Response
    {
        $response = $this->quotationService->refuseQuotation($token);

        if (array_key_exists('quotationNumber', $response)) {
            return $this->render('employee/quotation/acceptedAndRefused.html.twig', [
                'menuItems' => (new MenuBuilder)->createMainMenu(['connected' => false]),
                'footerItems' => (new MenuBuilder)->createMainFooter(),
                'quotationNumber' => $response['quotationNumber'],
                'status' => 'refused',
            ]);
        } else {
            return $this->render('employee/quotation/acceptedAndRefused.html.twig', [
                'menuItems' => (new MenuBuilder)->createMainMenu(['connected' => false]),
                'footerItems' => (new MenuBuilder)->createMainFooter(),
                'status' => 'error',
            ]);
        }
    }
}
