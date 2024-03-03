<?php

namespace App\Controller\Dashboard;

use App\Menu\MenuBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(): Response
    {
        dd("Dashboard");
        return $this->render('back/dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'menuItems' => (new MenuBuilder)->createMainMenu(['conntected' => $this->getUser() instanceof UserInterface]),
            'footerItems' => (new MenuBuilder)->createMainFooter(),
        ]);
    }
}