<?php

namespace App\Controller\Admin\Users;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Menu\MenuBuilder;
use App\Repository\TechcareUserRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\TechcareUser;
use App\Form\User\AdminCreateOrUpdateUserType;
use App\Service\EmailService;

class UsersController extends AbstractController
{
    #[Route('/admin/users', name: 'accueil_admin_users')]
    public function index(TechcareUserRepository $techcareUserRepository): Response
    {
        $usersFiltered = $techcareUserRepository->findUsersByRoles(['ROLE_COMPANY', 'ROLE_ACCOUNTANT', 'ROLE_OWNER_COMPANY']);
        $usersFilteredMapped = array_map(function ($user) {
            return [
//                'id' => $user->getId(),
                'firstname' => $user->getFirstname(),
                'lastname' => $user->getLastname(),
                'email' => $user->getEmail(),
                'roles' => $user->getRolesAsArrayName(),
                'company' => $user->getCompany() ? $user->getCompany()->getName() : 'Aucune',
                'createdAt' => $user->getCreatedAt()->format('d/m/Y H:i:s'),
                'actions' => [
                    'update' => [
                        'type' => 'button',
                        'path' => 'admin_user_update',
                        'label' => 'Modifier',
                        'id' => $user->getId(),
                    ],
                    'delete' => [
                        'type' => 'form',
                        'path' => 'admin_user_delete',
                        'label' => 'Supprimer',
                        'id' => $user->getId(),
                    ]
                ]
            ];
        }, $usersFiltered);

        $userConnected = $this->getUser() instanceof UserInterface;



        return $this->render('admin/users/index.html.twig', [
            'menuItems' => (new MenuBuilder)->createMainMenu(['connected' => $userConnected]),
            'footerItems' => (new MenuBuilder)->createMainFooter(),
            'datas' => $usersFilteredMapped,
            'title' => 'Utilisateurs',
            'entityProperties' => [
//                'id' => 'ID',
                'firstname' => 'Prénom',
                'lastname' => 'Nom',
                'email' => 'E-mail',
                'roles' => 'Rôles',
                'company' => 'Entreprise',
                'createdAt' => 'Date de création',
                'actions' => 'Actions',
            ],
        ]);
    }

    #[Route('/admin/users/delete/{id}', name: 'admin_user_delete', methods: ['POST'])]
    public function delete(Request $request, TechcareUser $techcareUser, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $techcareUser->getId(), $request->request->get('_token'))) {
            $entityManager->remove($techcareUser);
            $entityManager->flush();
        }

        return $this->redirectToRoute('accueil_admin_users', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/admin/users/add', name: 'admin_user_create', methods: ['POST', 'GET'])]
    public function createUser(Request $request, EntityManagerInterface $entityManager): Response
    {
        $newUser = new TechcareUser();

        $form = $this->createForm(AdminCreateOrUpdateUserType::class, $newUser, [
            'role_choices' => [
                'Employé entreprise' => 'ROLE_COMPANY',
                'Comptable' => 'ROLE_ACCOUNTANT',
            ],
            'new' => true
        ]);
        $form->handleRequest($request);

        $userConnected = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {

            $newUser->setUpdatedAt(new \DateTimeImmutable());
            $newUser->setCreatedAt(new \DateTimeImmutable());
            $newUser->setCreatedBy($userConnected->getId());
            $newUser->setPassword(
                password_hash($form->get('password')->getData(), PASSWORD_BCRYPT)
            );
            $entityManager->persist($newUser);
            $entityManager->flush();

            // TODO : send mail 

            return $this->redirectToRoute('accueil_admin_users');
        }

        return $this->render('admin/users/addUserFromAdmin.html.twig', [
            'menuItems' => (new MenuBuilder)->createMainMenu(['connected' => $userConnected]),
            'footerItems' => (new MenuBuilder)->createMainFooter(),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/users/{id}', name: 'admin_user_update', methods: ['POST', 'GET'])]
    public function updateUser(TechcareUser $techcareUser, Request $request, TechcareUserRepository $techcareUserRepository, EntityManagerInterface $entityManager): Response
    {
        $userConnected = $this->getUser();
        $form = $this->createForm(AdminCreateOrUpdateUserType::class, $techcareUser, [
            'role_choices' => [
                'Employé entreprise' => 'ROLE_COMPANY',
                'Comptable' => 'ROLE_ACCOUNTANT',
            ],
            'new' => false
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $techcareUser->setUpdatedAt(new \DateTimeImmutable());
            $techcareUser->setUpdatedBy($this->getUser()->getId());
            $entityManager->flush();

            return $this->redirectToRoute('accueil_admin_users');
        }
        return $this->render('admin/users/updateFromAdmin.html.twig', [
            'menuItems' => (new MenuBuilder)->createMainMenu(['connected' => $userConnected]),
            'footerItems' => (new MenuBuilder)->createMainFooter(),
            'form' => $form->createView(),
            'userId' => $techcareUser->getId(),
        ]);
    }

    #[Route('/admin/users/send_email/{id}', name: 'admin_user_send_email', methods: ['POST'])]
    public function sendEmailToUser(Request $request, TechcareUser $techcareUser, EmailService $emailService): Response
    {
        if ($this->isCsrfTokenValid('resetPwdRequest' . $techcareUser->getId(), $request->request->get('_token'))) {
            // TODO : send mail
            // $emailService->sendEmailForResetPassword(
            //     $this->getUser()->getFirstname() . ' ' . $this->getUser()->getLastname(),
            //     $this->getUser()->getEmail(),
            //     $techcareUser->getEmail(),
            //     $techcareUser->getFirstname() . ' ' . $techcareUser->getLastname(),
            //     "https://www.google.com"
            // );
        }

        return $this->redirectToRoute('accueil_admin_users', [], Response::HTTP_SEE_OTHER);


        return new Response('Email sent', 200);
    }
}
