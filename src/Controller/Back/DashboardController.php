<?php

namespace App\Controller\Back;

use App\Menu\MenuBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(): Response
    {
        return $this->render('back/dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'menuItems' => (new MenuBuilder)->createMainMenu(),
        ]);
    }
}
