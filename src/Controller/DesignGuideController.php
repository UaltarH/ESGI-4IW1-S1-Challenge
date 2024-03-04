<?php

namespace App\Controller;

use App\Menu\MenuBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class DesignGuideController extends AbstractController
{
    #[Route('/design-guide', name: 'design_guide_index')]
    public function index(ChartBuilderInterface $chartBuilder)
    {
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
        return $this->render('design_guide/index.html.twig', [
            'menuItems' => (new MenuBuilder)->createMainMenu([
                'connected' => false,
            ]),
            'footerItems' => (new MenuBuilder)->createMainFooter(),
            'chartLine' => $chartLine,
            'chartBar' => $chartBar,
            'entityProperties'=> [
                'name' => 'string',
                'description' => 'text',
                'price' => 'float',
                'quantity' => 'integer',
                'createdAt' => 'datetime',
                'updatedAt' => 'datetime',
            ],
            'datas' => [
                [
                    'name' => 'Product 1',
                    'description' => 'Description of product 1',
                    'price' => 10.5,
                    'quantity' => 100,
                    'createdAt' => (new \DateTime('2021-01-01'))->format('Y-m-d H:i:s'),
                    'updatedAt' => (new \DateTime('2021-01-01'))->format('Y-m-d H:i:s'),
                ],
                [
                    'name' => 'Product 2',
                    'description' => 'Description of product 2',
                    'price' => 20.5,
                    'quantity' => 200,
                    'createdAt' => (new \DateTime('2021-01-02'))->format('Y-m-d H:i:s'),
                    'updatedAt' => (new \DateTime('2021-01-02'))->format('Y-m-d H:i:s'),
                ],
                [
                    'name' => 'Product 3',
                    'description' => 'Description of product 3',
                    'price' => 30.5,
                    'quantity' => 300,
                    'createdAt' => (new \DateTime('2021-01-03'))->format('Y-m-d H:i:s'),
                    'updatedAt' => (new \DateTime('2021-01-03'))->format('Y-m-d H:i:s'),
                ],
            ],
        ]);
    }
}