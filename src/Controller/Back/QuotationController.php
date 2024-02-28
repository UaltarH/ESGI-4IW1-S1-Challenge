<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Menu\MenuBuilder;
use Symfony\Component\Security\Core\User\UserInterface;

class QuotationController extends AbstractController
{
    #[Route('/quotation', name: 'app_quotation')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
        return $this->render('back/quotation/index.html.twig', [
            'menuItems' => (new MenuBuilder)->createMainMenu(),
        ]);
    }
    #[Route('/quotation/new', name: 'app_quotation_new')]
    public function new(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
        return $this->render('back/quotation/create.html.twig', [
            'menuItems' => (new MenuBuilder)->createMainMenu(),
        ]);
    }
    #[Route('/quotation/delete{id}', name: 'app_quotation_delete')]
    public function delete(): Response
    {
        $user = $this->getUser();
        $hasAccess = $this->isGranted('ROLE_ADMIN');
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('back/quotation/index.html.twig', [
            'menuItems' => (new MenuBuilder)->createMainMenu(),
        ]);
    }
}