<?php

namespace App\Service\Chart;
use App\Repository\TechcareCompanyRepository;
use App\Repository\TechcareInvoiceRepository;
use DateTime;
use Exception;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class ChartService {
    private TechcareInvoiceRepository $invoiceRepository;
    private TechcareCompanyRepository $companyRepository;

    public function __construct(TechcareInvoiceRepository $invoiceRepository, TechcareCompanyRepository $companyRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
        $this->companyRepository = $companyRepository;
    }
    public function getStartDate(DateTime $end) : DateTime
    {
        $start = clone $end;
        $start->modify('-1 year');
        if(substr($start->format('Y-m-d'), 5, 2) === substr($end->format('Y-m-d'), 5, 2)){
            $start->modify('first day of next month')->setTime(0, 0);
        }
        return $start;
    }

    /**
     * @param ChartBuilderInterface $chartBuilder
     * @param string $company
     * @return array
     * @throws Exception
     */
    public function createInvoiceChart(ChartBuilderInterface $chartBuilder, string $company=''): array
    {
        if($company !== ''){
            $invoices = $this->invoiceRepository->findPaidInvoicesByCompany($company, $this->getStartDate(new DateTime()), new DateTime());
            $invoicesN_1 = $this->invoiceRepository->findPaidInvoicesByCompany($company, $this->getStartDate(new DateTime('-1 year')), new DateTime('-1 year'));
        } else {
            $invoices = $this->invoiceRepository->findPaidInvoices($this->getStartDate(new DateTime()), new DateTime());
            $invoicesN_1 = $this->invoiceRepository->findPaidInvoices($this->getStartDate(new DateTime('-1 year')), new DateTime('-1 year'));
        }
        $invoiceMappedByMonthYear = [];
        $invoiceMappedByMonthYearN_1 = [];
        $labels = [];

        $total = 0;
        $totalN_1 = 0;
        $count = 0;
        $countN_1 = 0;

        $startMonth = $this->getStartDate(new DateTime())->format('F Y');
        for($i = 0; $i < 12; $i++){
            $month = (new DateTime($startMonth))->modify("+$i month")->format('F');
            $labels[] = $month;
            $invoiceMappedByMonthYear[$month] = 0;
            $invoiceMappedByMonthYearN_1[$month] = 0;
        }

        foreach ($invoices as $invoice) {
            $month = $invoice->getCreatedAt()->format('F');
            $invoiceMappedByMonthYear[$month] += $invoice->getAmount();
            $total += $invoice->getAmount();
            $count++;
        }
        foreach ($invoicesN_1 as $invoice) {
            $month = $invoice->getCreatedAt()->format('F');
            $invoiceMappedByMonthYearN_1[$month] += $invoice->getPayment()->getAmount();
            $totalN_1 += $invoice->getPayment()->getAmount();
            $countN_1++;
        }

        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Sales of this year',
                    'backgroundColor' => '#368F8B',
                    'borderColor' => '#368F8B',
                    'data' => array_values($invoiceMappedByMonthYear),
                ],
                [
                    'label' => 'Sales of the year N-1',
                    'backgroundColor' => '#ddd',
                    'borderColor' => '#ddd',
                    'data' => array_values($invoiceMappedByMonthYearN_1),
                ],
            ],
        ]);
        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 10000,
                    'title' => [
                        'display' => true,
                        'text' => 'Sales (€)',
                    ],
                ],
            ],
        ]);
        return ['chart'=>$chart, 'total'=>$total, 'count'=>$count, 'totalN_1'=>$totalN_1, 'countN_1'=>$countN_1];
    }

    public function createProductCategorySalesChart(ChartBuilderInterface $chartBuilder, string $company=''): Chart
    {
        if($company !== ''){
            $sales = $this->invoiceRepository->findProductCategorySalesByCompany($company, $this->getStartDate(new DateTime()), new DateTime());
            $salesN_1 = $this->invoiceRepository->findProductCategorySalesByCompany($company, $this->getStartDate(new DateTime('-1 year')), new DateTime('-1 year'));
        } else {
            $sales = $this->invoiceRepository->findProductCategorySales($this->getStartDate(new DateTime()), new DateTime());
            $salesN_1 = $this->invoiceRepository->findProductCategorySales($this->getStartDate(new DateTime('-1 year')), new DateTime('-1 year'));
        }
        $labels = [];
        $data = [];
        $dataN_1 = [];
        foreach ($sales as $sale) {
            $labels[] = $sale['name'];
            $data[] = $sale['total'];
        }
        foreach ($salesN_1 as $sale) {
            if(!in_array($sale['name'], $labels))
                $labels[] = $sale['name'];
            $dataN_1[] = $sale['total'];
        }
        $chart = $chartBuilder->createChart(Chart::TYPE_BAR);
        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Sales by category',
                    'backgroundColor' => [
                        '#368F8B',
                    ],
                    'borderColor' => [
                        '#368F8B',
                    ],
                    'data' => $data,
                ],
                [
                    'label' => 'Sales by category N-1',
                    'backgroundColor' => [
                        '#ddd',
                    ],
                    'borderColor' => [
                        '#ddd',
                    ],
                    'data' => $dataN_1,
                ],
            ],
        ]);
        $chart->setOptions([
            'indexAxis' => 'x',
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 10000,
                    'title' => [
                        'display' => true,
                        'text' => 'Sales (€)',
                    ],
                ],
            ],
        ]);
        return $chart;
    }
    public function createBrandSalesChart(ChartBuilderInterface $chartBuilder, string $company=''): Chart
    {
        if($company !== ''){
            $sales = $this->invoiceRepository->findBrandSalesByCompany($company, $this->getStartDate(new DateTime()), new DateTime());
            $salesN_1 = $this->invoiceRepository->findBrandSalesByCompany($company, $this->getStartDate(new DateTime('-1 year')), new DateTime('-1 year'));
        } else {
            $sales = $this->invoiceRepository->findBrandSales($this->getStartDate(new DateTime()), new DateTime());
            $salesN_1 = $this->invoiceRepository->findBrandSales($this->getStartDate(new DateTime('-1 year')), new DateTime('-1 year'));
        }
        $labels = [];
        $data = [];
        $dataN_1 = [];
        foreach ($sales as $sale) {
            $labels[] = $sale['name'];
            $data[] = $sale['total'];
        }
        foreach ($salesN_1 as $sale) {
            if(!in_array($sale['name'], $labels))
                $labels[] = $sale['name'];
            $dataN_1[] = $sale['total'];
        }
        $chart = $chartBuilder->createChart(Chart::TYPE_BAR);
        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Sales by brand',
                    'backgroundColor' => [
                        '#368F8B',
                    ],
                    'borderColor' => [
                        '#368F8B',
                    ],
                    'data' => $data,
                ],
                [
                    'label' => 'Sales by brand N-1',
                    'backgroundColor' => [
                        '#ddd',
                    ],
                    'borderColor' => [
                        '#ddd',
                    ],
                    'data' => $dataN_1,
                ],
            ],
        ]);
        $chart->setOptions([
            'indexAxis' => 'x',
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 10000,
                    'title' => [
                        'display' => true,
                        'text' => 'Sales (€)',
                    ],
                ],
            ],
        ]);
        return $chart;
    }

    public function createCompanyChart(ChartBuilderInterface $chartBuilder): array
    {
        $companies = $this->companyRepository->countCompaniesBetweenPeriod($this->getStartDate(new DateTime()), new DateTime());
        $labels = [];
        $data = [];
        $startMonth = $this->getStartDate(new DateTime())->format('F Y');
        for($i = 0; $i < 12; $i++){
            $month = (new DateTime($startMonth))->modify("+$i month")->format('F');
            $labels[] = $month;
            $data[$month] = 0;
        }
        foreach ($companies as $company) {
            $month = $company->getCreatedAt()->format('F');
            $data[$month] ++;
        }
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Companies created',
                    'backgroundColor' => '#368F8B',
                    'borderColor' => '#368F8B',
                    'data' => array_values($data),
                ],
            ],
        ]);
        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                    'title' => [
                        'display' => true,
                        'text' => 'Nb companies joined',
                    ],
                ],
            ],
        ]);
        return ['chart'=>$chart, 'total'=>count($companies)];
    }
}