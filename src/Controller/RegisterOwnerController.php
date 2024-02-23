<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\TechcareUser;
use App\Form\USer\RegisterOwnerType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;



class RegisterOwnerController extends AbstractController
{
    #[Route('/register', name: 'app_register', methods: ['POST', 'GET'])]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {

        $user = new TechcareUser();
        $form = $this->createForm(RegisterOwnerType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                password_hash($form->get('password')->getData(), PASSWORD_BCRYPT)
            );
            $user->setRoles(['ROLE_OWNER_COMPANY']);
            $user->setCreatedAt(new \DateTimeImmutable());
            $user->setCreatedBy('system');

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }


        return $this->render('register_owner/index.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
