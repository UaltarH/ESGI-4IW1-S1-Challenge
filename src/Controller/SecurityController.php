<?php

namespace App\Controller;

use App\Menu\MenuBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('default_index');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig',
            [
                'last_username' => $lastUsername,
                'error' => $error,
                'menuItems' => (new MenuBuilder)->createMainMenu(['conntected' => $this->getUser() instanceof UserInterface]),
                'footerItems' => (new MenuBuilder)->createMainFooter(),
            ],
        );
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        // throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
        // return $this->redirectToRoute('app_login');
    }
    #[Route(path: '/access-denied', name: 'app_access_denied')]
    public function accessDenied(): Response
    {
        if($this->getUser()) {
            return $this->redirectToRoute('default_index');
        }
        return $this->redirectToRoute('app_login');
    }
}
