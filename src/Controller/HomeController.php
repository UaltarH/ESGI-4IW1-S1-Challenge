<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Menu\MenuBuilder;
use Symfony\Component\Security\Core\User\UserInterface;

use App\Utilities\EmailUtils;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home_index')]
    public function index(EmailUtils $emailUtils): Response
    {
        // test email
        // $emailUtils->sendEmailForInscriptionUsingBrevo(
        //     "admin",
        //     "admin@couillase.com",
        //     "mathieupannetrat5@gmail.com",
        //     "Mathieu Pannetrat",
        //     "https://www.google.com"
        // );

        // $base64 = base64_encode(file_get_contents('https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png'));

        // $emailUtils->sendEmailForQuoteUsingBrevo(
        //     "admin",
        //     "admin@couillase.com",
        //     "mathieupannetrat5@gmail.com",
        //     "Mathieu",
        //     "12/09/2024",
        //     "Company Name",
        //     $base64,
        //     "Facture_Pannetrat_12/09/2024.png",
        // );

        // $emailUtils->sendEmailForInvoiceUsingBrevo(
        //     "admin",
        //     "admin@couillase.com",
        //     "mathieupannetrat5@gmail.com",
        //     "Mathieu",
        //     "12/09/2024",
        //     "Company Name",
        //     $base64,
        //     "Facture_Pannetrat_12/09/2024.png"
        // );
        //

        $connected = $this->getUser() instanceof UserInterface;
        return $this->render('employee/index.html.twig', [
            'menuItems' => (new MenuBuilder)->createMainMenu([
                'connected' => $connected,
                'role' => $connected ? $this->getUser()->getRoles()[0] : null,
            ]),
            'footerItems' => (new MenuBuilder)->createMainFooter(),
            'company' => $connected ? $this->getUser()->getCompany()->getName() : null,
        ]);
    }
}
