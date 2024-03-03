<?php

namespace App\Controller\Company;

use App\Entity\TechcareCompany;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Menu\MenuBuilder;
use App\Service\CompanyService;
use App\Form\Company\EditCompanyType;
use Doctrine\ORM\EntityManagerInterface;

class CompanyManagerController extends AbstractController
{
    private CompanyService $companyService;
    private EntityManagerInterface $entityManager;

    public function __construct(CompanyService $companyService, EntityManagerInterface $entityManager)
    {
        $this->companyService = $companyService;
        $this->entityManager = $entityManager;
    }

    #[Route('/company/manager', name: 'company_manager')]
    public function index(): Response
    {
        $userConnected = $this->getUser();

        $datas = $this->companyService->manager();

        return $this->render('Company/index.html.twig', [
            'menuItems' => (new MenuBuilder)->createMainMenu(['connected' => $userConnected instanceof UserInterface]),
            'footerItems' => (new MenuBuilder)->createMainFooter(),
            'datas' => $datas['datasTable'],
            'entityProperties' => $datas['entityProperties'],
        ]);
    }

    #[Route('/company/edit/{id}', name: 'company_edit')]
    public function edit(TechcareCompany $company, Request $request): Response
    {
        $userConnected = $this->getUser();
        $form = $this->createForm(EditCompanyType::class, $company);
        $form->handleRequest($request);

        $bool = $this->companyService->editCompany($company, $form);
        if ($bool) {
            return $this->redirectToRoute('company_manager');
        } else {
            return $this->render('Company/edit.html.twig', [
                'menuItems' => (new MenuBuilder)->createMainMenu(['connected' => $userConnected instanceof UserInterface]),
                'footerItems' => (new MenuBuilder)->createMainFooter(),
                'form' => $form->createView(),
            ]);
        }
    }

    // #[Route('/company/delete/{id}', name: 'company_delete')]
    // public function delete(TechcareCompany $company, Request $request): Response
    // {
    //     if ($this->isCsrfTokenValid('delete' . $company->getId(), $request->request->get('_token'))) {
    //         $this->entityManager->remove($company);
    //         $this->entityManager->flush();
    //     }

    //     return $this->redirectToRoute('company_manager', [], Response::HTTP_SEE_OTHER);
    // }
}
