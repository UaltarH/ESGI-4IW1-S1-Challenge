<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\EmailService;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(EmailService $emailService): Response
    {
        // test email
        // $emailService->sendEmailForInscriptionUsingBrevo(
        //     "admin",
        //     "admin@couillase.com",
        //     "mathieupannetrat5@gmail.com",
        //     "Mathieu Pannetrat",
        //     "https://www.google.com"
        // );

        // $base64 = base64_encode(file_get_contents('https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png'));

        // $emailService->sendEmailForQuoteUsingBrevo(
        //     "admin",
        //     "admin@couillase.com",
        //     "mathieupannetrat5@gmail.com",
        //     "Mathieu",
        //     "12/09/2024",
        //     "Company Name",
        //     $base64,
        //     "Facture_Pannetrat_12/09/2024.png",
        // );

        // $emailService->sendEmailForInvoiceUsingBrevo(
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

        return $this->render('back/dashboard/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
