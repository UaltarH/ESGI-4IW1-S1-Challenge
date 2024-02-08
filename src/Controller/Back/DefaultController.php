<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Menu\MenuBuilder;
use Symfony\Component\Security\Core\User\UserInterface;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'default_index')]
    public function index(): Response
    {
        $connected = $this->getUser() instanceof UserInterface;
        return $this->render('back/default/index.html.twig', [
            'menuItems' => (new MenuBuilder)->createMainMenu(['connected' => $connected]),
        ]);
    }
}