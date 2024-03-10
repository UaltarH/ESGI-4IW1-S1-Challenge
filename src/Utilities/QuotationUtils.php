<?php

namespace App\Utilities;

use App\Utilities\CommonUtils;
use App\Entity\TechcareQuotation;
use App\Entity\TechcareQuotationContent;
use App\Enum\QuotationStatus;
use App\Repository\TechcareServiceRepository;
use DateTimeImmutable;

class QuotationUtils
{
    private TechcareServiceRepository $serviceRepository;
    private CommonUtils $commonUtils;

    public function __construct(TechcareServiceRepository $serviceRepository, CommonUtils $commonUtils)
    {
        $this->commonUtils = $commonUtils;
        $this->serviceRepository = $serviceRepository;
    }

    public function sortQuotationsByDate($quotations)
    {
        usort($quotations, function ($a, $b) {
            $updatedAtA = $a->getUpdatedAt() ?? new DateTimeImmutable('0000-00-00');
            $updatedAtB = $b->getUpdatedAt() ?? new DateTimeImmutable('0000-00-00');

            return $updatedAtB <=> $updatedAtA;
        });
        return $quotations;
    }

    public function getArrayEntityMappedUsedForTable($quotations)
    {
        return array_map(function ($quotation) {
            $date = $quotation->getUpdatedAt() ?? $quotation->getCreatedAt();
            $date = $date->format('d/m/Y H:i');
            $object =  [
                'quotation_number' => $quotation->getQuotationNumber(),
                'client' => $quotation->getClient()->getFirstname() . ' ' . $quotation->getClient()->getLastname(),
                'created_by' => $quotation->getCreatedBy(),
                'last_modif' => $date,
                'amount' => $quotation->getAmount(),
                'status' => $quotation->getStatusName(),
                'actions' => [
                    'show' => [
                        'type' => 'button',
                        'path' => 'app_quotation_show',
                        'label' => 'Voir',
                        'id' => $quotation->getId(),
                    ],
                    'send' => [
                        'type' => 'button',
                        'path' => 'app_quotation_pdf',
                        'label' => 'Envoyer',
                        'id' => $quotation->getId(),
                    ],
                ]
            ];
            if ($quotation->getStatus() == QuotationStatus::refused->value) {
                $object['actions']['update'] = [
                    'type' => 'button',
                    'path' => 'app_quotation_edit',
                    'label' => 'Modifier',
                    'id' => $quotation->getId(),
                ];
                $object['actions']['delete'] = [
                    'type' => 'form',
                    'path' => 'app_quotation_delete',
                    'label' => 'Supprimer',
                    'id' => $quotation->getId(),
                ];
            }
            return $object;
        }, $quotations);
    }

    public function prepareDataForPdfOrPreview(TechcareQuotation $quotation)
    {
        $company = $quotation->getClient()->getCompany();
        $arrayQuotationContent = $quotation->getContents();
        $logoTechcare = $this->commonUtils->getLogoTechcareForPdf();

        $data = [
            'techcareLogo'  => $logoTechcare,
            'name_company' => $company->getName(),
            'address_company' => $company->getAddress(),
            'phone_number_company' => $company->getPhoneNumber(),
            'email_company' => $company->getEmail(),
            'firstname_client' => $quotation->getClient()->getFirstname(),
            'lastname_client' => $quotation->getClient()->getLastname(),
            'email_client' => $quotation->getClient()->getEmail(),
            'quotation_number' => $quotation->getQuotationNumber(),
            'quotation_date' => $quotation->getCreatedAt()->format('d/m/Y'),
            'quotation_description' => $quotation->getDescription(),
            'quotation_productName' => $arrayQuotationContent[0]->getProduct()->getName(),
            'quotation_discount' => $quotation->getDiscount(),
            'quotation_amount' => $quotation->getAmount(),
        ];
        $priceAllContent = 0;
        //collection d'entité techcareQuotationContent
        foreach ($arrayQuotationContent as $content) {
            if ($content instanceof TechcareQuotationContent) {
                $contentArray = [
                    'name' => $content->getService()->getName(),
                    'price' => $content->getAmount(),
                ];
                if ($content->getComponent() !== null) {
                    $contentArray['componentName'] = $content->getComponent()->getName();
                } else {
                    $contentArray['componentName'] = null;
                }
                $data['contents'][] = $contentArray;
                $priceAllContent = $priceAllContent + $content->getAmount();
            }
        }
        if ($data['quotation_discount'] == null) {
            $data['quotation_discount'] = 0;
        }
        $data['priceAllContent'] = $priceAllContent;
        $data['priceWithTax'] = $priceAllContent * 1.2;

        return $data;
    }

    public function getDatasForCreatAndEditQuotation($company)
    {
        $services = $this->serviceRepository->findAll();
        $servicesMapped = array_map(function ($service) {
            return [
                'id' => $service->getId(),
                'name' => $service->getName(),
            ];
        }, $services);

        $clientsCompany = $company->getClient();
        $clientsCompanyMapped = $clientsCompany->map(function ($client) {
            return [
                'id' => $client->getId(),
                'name' => $client->getFirstname() . ' ' . $client->getLastname(),
            ];
        });

        $productsCompany = $company->getProducts();

        $productsWithComponents = [];
        foreach ($productsCompany as $product) {
            $components = $product->getComponents();
            $componentsArray = [];

            foreach ($components as $component) {
                $componentsArray[] = [
                    'id' => $component->getId(),
                    'name' => $component->getName(),
                ];
            }

            $productsWithComponents[] = [
                'product' => [
                    'id' => $product->getId(),
                    'name' => $product->getName(),
                    'brand' => $product->getBrand()->getName(),
                    'category' => $product->getProductCategory()->getName(),
                    'components' => $componentsArray,
                ],
            ];
        }

        return [
            'services' => $servicesMapped,
            'clients' => $clientsCompanyMapped,
            'products' => $productsWithComponents,
        ];
    }
}
