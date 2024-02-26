<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\TechcareUser;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\Abstract\registerCompany;
use App\Entity\TechcareCompany;


class RegisterOwnerController extends AbstractController
{
    #[Route('/register', name: 'app_register', methods: ['POST', 'GET'])]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(registerCompany::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $ownerUser = new TechcareUser();
            $company = new TechcareCompany();

            $ownerUser->setFirstname($formData['firstName']);
            $ownerUser->setLastname($formData['lastName']);
            $ownerUser->setEmail($formData['email']);
            $ownerUser->setPassword(
                password_hash($formData['password'], PASSWORD_BCRYPT)
            );
            $ownerUser->setRoles(['ROLE_OWNER_COMPANY']);
            $ownerUser->setCreatedAt(new \DateTimeImmutable());
            $ownerUser->setCreatedBy('system');

            $entityManager->persist($ownerUser);


            $company->setName($formData['companyName']);
            $company->setSiret($formData['companySiret']);
            $company->setPhoneNumber($formData['companyPhoneNumber']);
            $company->setEmail($formData['companyEmail']);
            $company->setAddress($formData['companyAddress']);
            $company->setActive(true);
            $company->setOwner($ownerUser);
            $company->setCode('code');
            $company->setCreatedAt(new \DateTimeImmutable());
            $company->setCreatedBy('system');

            $entityManager->persist($company);

            $ownerUser->setCompany($company);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
