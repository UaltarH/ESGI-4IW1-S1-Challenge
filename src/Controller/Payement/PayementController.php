<?php

namespace App\Controller\Payement;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Menu\MenuBuilder;
use App\Service\Payement\PayementService;

class PayementController extends AbstractController
{
    private PayementService $payementService;

    public function __construct(
        PayementService $payementService
    ) {
        $this->payementService = $payementService;
    }

    #[Route('/payementList', name: 'payement_list')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');

        $userConnected = $this->getUser();

        $datas = $this->payementService->getPayements($userConnected);

        return $this->render('employee/payement/index.html.twig', [
            'datas' => $datas['datas'],
            'menuItems' => (new MenuBuilder)->createMainMenu(['connected' => $this->getUser() instanceof UserInterface]),
            'footerItems' => (new MenuBuilder)->createMainFooter(),
            'entityProperties' => $datas['entityProperties'],
        ]);
    }

    #[Route('/payement/{token}', name: 'payement_action')]
    public function action(string $token): Response
    {
        $result = $this->payementService->action($token);

        if ($result == '') {
            return $this->render('employee/payement/action.html.twig', [
                'menuItems' => (new MenuBuilder)->createMainMenu(['connected' => false]),
                'footerItems' => (new MenuBuilder)->createMainFooter(),
            ]);
        } else {
            return $this->render('employee/payement/action.html.twig', [
                'menuItems' => (new MenuBuilder)->createMainMenu(['connected' => false]),
                'footerItems' => (new MenuBuilder)->createMainFooter(),
                'invoiceName' => $result,
            ]);
        }
    }
}
