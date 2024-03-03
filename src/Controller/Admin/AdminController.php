<?php

namespace App\Controller\Admin;

use App\Repository\TechcareCompanyRepository;
use App\Repository\TechcareInvoiceRepository;
use App\Repository\TechcareQuotationRepository;
use App\Service\Chart\ChartService;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Menu\MenuBuilder;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;

class AdminController extends AbstractController
{
    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     * @throws Exception
     */
    #[Route('/admin/dashboard', name: 'app_admin_dashboard_index')]
    public function index(ChartBuilderInterface $chartBuilder, ChartService $chartService,
                          TechcareCompanyRepository $companyRepository, TechcareInvoiceRepository $invoiceRepository,
                          TechcareQuotationRepository $quotationRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $salesChart = $chartService->createInvoiceChart($chartBuilder);
        $newCompaniesChart = $chartService->createCompanyChart($chartBuilder);

        return $this->render('admin/dashboard/admin.html.twig', [
            'menuItems' => (new MenuBuilder)->createMainMenu([
                'connected' => true,
                'role' => $this->getUser()->getRoles()[0],
            ]),
            'footerItems' => (new MenuBuilder)->createMainFooter(),
            'salesChart' => $salesChart['chart'],
            'companiesChart' => $newCompaniesChart['chart'],
            'totalNewCompanies' => $newCompaniesChart['total'],
            'totalCompanies' => $companyRepository->countCompanies(),
            'totalInvoices' => $invoiceRepository->countInvoices(),
            'totalQuotations' => $quotationRepository->countQuotations(),
        ]);
    }
}
