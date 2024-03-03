<?php

namespace App\Controller\Users;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Menu\MenuBuilder;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Service\Users\UsersManagerService;
use App\Entity\TechcareUser;
use App\Form\User\CreateUserType;
use App\Form\User\EditUserType;
use Doctrine\ORM\EntityManagerInterface;

class UsersManagerController extends AbstractController
{
    private UsersManagerService $usersCompanyService;
    private EntityManagerInterface $entityManager;

    public function __construct(
        UsersManagerService $usersCompanyService,
        EntityManagerInterface $entityManager
    ) {
        $this->usersCompanyService = $usersCompanyService;
        $this->entityManager = $entityManager;
    }


    #[Route('/users/company/manager', name: 'users_company_manager')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_OWNER_COMPANY');
        $userConnected = $this->getUser();
        $datas = $this->usersCompanyService->manager($userConnected);

        return $this->render('employee/user/index.html.twig', [
            'menuItems' => (new MenuBuilder)->createMainMenu([
                'connected' => $userConnected instanceof UserInterface,
                'role' => $userConnected->getRoles()[0],
            ]),
            'footerItems' => (new MenuBuilder)->createMainFooter(),
            'entityProperties' => $datas['entityProperties'],
            'datas' => $datas['datas'],
        ]);
    }

    #[Route('/users/company/manager/create', name: 'users_company_manager_create')]
    public function create(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_OWNER_COMPANY');
        $userConnected = $this->getUser();

        $newUser = new TechcareUser();
        $form = $this->createForm(CreateUserType::class, $newUser, [
            'role_choices' => [
                'Employé entreprise' => 'ROLE_COMPANY',
                'Comptable' => 'ROLE_ACCOUNTANT',
            ]
        ]);
        $form->handleRequest($request);

        $bool = $this->usersCompanyService->createUser($newUser, $form, $userConnected);
        if ($bool) {
            $this->addFlash('success', 'Nouvel employé ajouté avec succès !');
            return $this->redirectToRoute('users_company_manager');
        } else {
            return $this->render('employee/user/create.html.twig', [
                'menuItems' => (new MenuBuilder)->createMainMenu([
                    'connected' => $userConnected instanceof UserInterface,
                    'role' => $userConnected->getRoles()[0],
                ]),
                'footerItems' => (new MenuBuilder)->createMainFooter(),
                'form' => $form->createView(),
            ]);
        }
    }

    #[Route('/users/company/manager/update/{id}', name: 'users_company_manager_update')]
    public function update(Request $request, TechcareUser $techcareUser): Response | Exception
    {
        $this->denyAccessUnlessGranted('ROLE_OWNER_COMPANY');
        if($techcareUser->getCompany() !== $this->getUser()->getCompany()) {
            return $this->createAccessDeniedException('Vous n\'avez pas les droits pour modifier cet employé !');
        }
        $userConnected = $this->getUser();
        $form = $this->createForm(EditUserType::class, $techcareUser, [
            'role_choices' => [
                'Employé entreprise' => 'ROLE_COMPANY',
                'Comptable' => 'ROLE_ACCOUNTANT',
            ]
        ]);
        $form->handleRequest($request);

        $bool = $this->usersCompanyService->updateUser($techcareUser, $form, $userConnected);
        if ($bool) {
            $this->addFlash('success', 'Employé modifié avec succès !');
            return $this->redirectToRoute('users_company_manager');
        } else {
            return $this->render('employee/user/update.html.twig', [
                'menuItems' => (new MenuBuilder)->createMainMenu([
                    'connected' => $userConnected instanceof UserInterface,
                    'role' => $userConnected->getRoles()[0],
                ]),
                'footerItems' => (new MenuBuilder)->createMainFooter(),
                'form' => $form->createView(),
            ]);
        }
    }

    #[Route('/users/company/manager/delete/{id}', name: 'users_company_manager_delete')]
    public function delete(TechcareUser $techcareUser, Request $request): Response | Exception
    {
        $this->denyAccessUnlessGranted('ROLE_OWNER_COMPANY');
        if($techcareUser->getCompany() !== $this->getUser()->getCompany()) {
            return $this->createAccessDeniedException('Vous n\'avez pas les droits pour supprimer cet employé !');
        }
        if ($this->isCsrfTokenValid('delete' . $techcareUser->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($techcareUser);
            $this->entityManager->flush();
            $this->addFlash('success', 'Employé supprimé avec succès !');
        }

        return $this->redirectToRoute('users_company_manager', [], Response::HTTP_SEE_OTHER);
    }
}
