<?php

namespace App\Controller\Dashboard;

use App\Menu\MenuBuilder;
use App\Service\Chart\ChartService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;

class DashboardController extends AbstractController
{
    /**
     * @throws Exception
     */
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(ChartBuilderInterface $chartBuilder,ChartService $chartService): Response | Exception
    {
        if(!$this->isGranted('ROLE_ACCOUNTANT') && !$this->isGranted('ROLE_OWNER_COMPANY')) {
            return $this->createAccessDeniedException('Vous n\'avez pas les droits pour accéder à cette page');
        }
        $company = $this->getUser()->getCompany()->getName();
        $salesChart = $chartService->createInvoiceChart($chartBuilder, $company);
        $productChart = $chartService->createProductCategorySalesChart($chartBuilder, $company);
        $brandChart = $chartService->createBrandSalesChart($chartBuilder, $company);
        $salesN_1 = $salesChart['totalN_1'] > 0 ? $salesChart['totalN_1'] : 1;
        $countN_1 = $salesChart['countN_1'] > 0 ? $salesChart['countN_1'] : 1;

        $growth = ($salesChart['total'] - $salesN_1) / $salesN_1 * 100;
        $repairGrowth = ($salesChart['count'] - $countN_1) / $countN_1 * 100;
        return $this->render('admin/dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'menuItems' => (new MenuBuilder)->createMainMenu([
                'connected' => $this->getUser() instanceof UserInterface,
                'role' => $this->getUser()->getRoles()[0],
            ]),
            'footerItems' => (new MenuBuilder)->createMainFooter(),
            'company' => $company,
            'mainChart' => $salesChart['chart'],
            'smallChart1' => $productChart,
            'smallChart2' => $brandChart,
            'totalSales' =>number_format($salesChart['total'], 2, ',', ' '),
            'totalDevicesRepaired' => number_format($salesChart['count'], 0, ',', ' '),
            'growth' => number_format($growth, 2, ',', ' '),
            'repairGrowth' => number_format($repairGrowth, 2, ',', ' '),
        ]);
    }
}
