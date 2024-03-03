<?php
namespace App\Controller;
use App\Menu\MenuBuilder;
use App\Repository\TechcareCompanyRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class DefaultController extends AbstractController
{
    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    #[Route('/', name: 'default_index')]
    public function index(TechcareCompanyRepository $companyRepository, ChartBuilderInterface $chartBuilder): Response
    {
        $connected = $this->getUser() instanceof UserInterface;

        $chartLine = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chartLine->setData([
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                [
                    'label' => 'Sales',
                    'backgroundColor' => '#368F8B',
                    'borderColor' => '#368F8B',
                    'data' => [8600, 2500, 8000, 3000, 3000, 4500, 15000],
                ],
                [
                    'label' => 'Sales N-1',
                    'backgroundColor' => '#ddd',
                    'borderColor' => '#ddd',
                    'data' => [2000, 3500, 6300, 4500, 2830, 2687, 12500],
                ]
            ],
        ]);
        $chartLine->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                    'title' => [
                        'display' => true,
                        'text' => 'Sales (€)',
                    ],
                ],
            ],
        ]);

        $chartBar = $chartBuilder->createChart(Chart::TYPE_BAR);
        $chartBar->setData([
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                [
                    'label' => 'Sales',
                    'backgroundColor' => '#368F8B',
                    'borderColor' => '#368F8B',
                    'data' => [800, 200, 800, 300, 300, 450, 1500],
                ],
                [
                    'label' => 'Sales N-1',
                    'backgroundColor' => '#ddd',
                    'borderColor' => '#ddd',
                    'data' => [200, 350, 300, 400, 280, 267, 1200],
                ]
            ],
        ]);
        $chartBar->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                    'title' => [
                        'display' => true,
                        'text' => 'Sales (Qty)',
                    ],
                ],
            ],
        ]);

        return $this->render('default/index.html.twig', [
            'menuItems' => (new MenuBuilder)->createMainMenu([
                'connected' => $connected,
                'role' => $connected ? $this->getUser()->getRoles()[0] : null,
            ]),
            'footerItems' => (new MenuBuilder)->createMainFooter(),
            'company' => $connected ? $this->getUser()->getCompany()->getName() : null,
            'totalCompanies' => $companyRepository->countCompanies(),
            'chartLine' => $chartLine,
            'chartBar' => $chartBar,
        ]);
    }
}