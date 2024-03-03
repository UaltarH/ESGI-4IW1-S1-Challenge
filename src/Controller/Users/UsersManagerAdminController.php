<?php

namespace App\Controller\Users;


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
use App\Service\Users\UsersManagerAdminService;
use App\Utilities\EmailUtils;

class UsersManagerAdminController extends AbstractController
{
    private UsersManagerAdminService $userManagerAdminService;

    public function __construct(UsersManagerAdminService $userManagerAdminService)
    {
        $this->userManagerAdminService = $userManagerAdminService;
    }

    #[Route('/admin/users', name: 'accueil_admin_users')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $datas = $this->userManagerAdminService->getUsers();

        $userConnected = $this->getUser() instanceof UserInterface;

        return $this->render('admin/users/index.html.twig', [
            'menuItems' => (new MenuBuilder)->createMainMenu([
                'connected' => $userConnected,
                'role' => 'ROLE_ADMIN'
            ]),
            'footerItems' => (new MenuBuilder)->createMainFooter(),
            'datas' => $datas['datas'],
            'entityProperties' => $datas['entityProperties'],
        ]);
    }

    #[Route('/admin/users/delete/{id}', name: 'admin_user_delete', methods: ['POST'])]
    public function delete(Request $request, TechcareUser $techcareUser, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if ($this->isCsrfTokenValid('delete' . $techcareUser->getId(), $request->request->get('_token'))) {
            $entityManager->remove($techcareUser);
            $entityManager->flush();
        }

        return $this->redirectToRoute('accueil_admin_users', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/admin/users/add', name: 'admin_user_create', methods: ['POST', 'GET'])]
    public function createUser(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
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

        $bool = $this->userManagerAdminService->createUser($form, $userConnected, $newUser);

        if ($bool) {
            return $this->redirectToRoute('accueil_admin_users');
        } else {
            return $this->render('admin/users/addUserFromAdmin.html.twig', [
                'menuItems' => (new MenuBuilder)->createMainMenu([
                    'connected' => $userConnected instanceof UserInterface,
                    'role' => 'ROLE_ADMIN'
                ]),
                'footerItems' => (new MenuBuilder)->createMainFooter(),
                'form' => $form->createView(),
            ]);
        }
    }

    #[Route('/admin/users/{id}', name: 'admin_user_update', methods: ['POST', 'GET'])]
    public function updateUser(TechcareUser $techcareUser, Request $request, TechcareUserRepository $techcareUserRepository, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $userConnected = $this->getUser();
        $form = $this->createForm(AdminCreateOrUpdateUserType::class, $techcareUser, [
            'role_choices' => [
                'Employé entreprise' => 'ROLE_COMPANY',
                'Comptable' => 'ROLE_ACCOUNTANT',
            ],
            'new' => false
        ]);
        $form->handleRequest($request);

        $bool = $this->userManagerAdminService->updateUser($form, $techcareUser, $userConnected);

        if ($bool) {
            return $this->redirectToRoute('accueil_admin_users');
        } else {
            return $this->render('admin/users/updateFromAdmin.html.twig', [
                'menuItems' => (new MenuBuilder)->createMainMenu([
                    'connected' => $userConnected,
                    'role' => 'ROLE_ADMIN'
                ]),
                'footerItems' => (new MenuBuilder)->createMainFooter(),
                'form' => $form->createView(),
                'userId' => $techcareUser->getId(),
            ]);
        }
    }

    #[Route('/admin/users/send_email/{id}', name: 'admin_user_send_email', methods: ['POST'])]
    public function sendEmailToUser(Request $request, TechcareUser $techcareUser, EmailUtils $emailUtils): Response
    {
        if ($this->isCsrfTokenValid('resetPwdRequest' . $techcareUser->getId(), $request->request->get('_token'))) {
            // TODO : send mail
            // $emailUtils->sendEmailForResetPassword(
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
