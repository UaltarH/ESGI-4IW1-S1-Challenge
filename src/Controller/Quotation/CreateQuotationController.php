<?php

namespace App\Controller\Quotation;

use App\Repository\TechcareCompanyRepository;
use App\Repository\TechcareQuotationRepository;
use App\Repository\TechcareServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\TechcareQuotation;
use App\Repository\TechcareClientRepository;
use App\Repository\TechcareProductRepository;
use Faker\Factory;
use App\Entity\QuotationStatus;
use App\Entity\TechcareComponent;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\TechcareQuotationContent;
use App\Repository\TechcareComponentRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Menu\MenuBuilder;

class CreateQuotationController extends AbstractController
{
    #[Route('/create/quotation', name: 'app_create_quotation')]
    public function index(TechcareServiceRepository $techcareServiceRepository): Response
    {
        $userConnected = $this->getUser() instanceof UserInterface;
        $company = $this->getUser()->getCompany();

        $services = $techcareServiceRepository->findAll();
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
        return $this->render('create_quotation/index.html.twig', [
            'menuItems' => (new MenuBuilder)->createMainMenu(['connected' => $userConnected]),
            'footerItems' => (new MenuBuilder)->createMainFooter(),
            'services' => $servicesMapped,
            'clients' => $clientsCompanyMapped,
            'productsAndComponents' => $productsWithComponents,
        ]);
    }

    #[Route('/create/quotation/post', name: 'app_create_quotation_post')]
    public function post(Request $request, EntityManagerInterface $entityManager, TechcareComponentRepository $componentsRepository, TechcareServiceRepository $serviceRepository, TechcareQuotationRepository $quotationRepository, TechcareClientRepository $clientRepository, TechcareProductRepository $productRepository): Response
    {
        $faker = Factory::create('fr_FR');
        $jsonData = json_decode($request->getContent(), true);

        //get entities with the json data
        $clientSelected = $clientRepository->find($jsonData['clientId']);
        $productSelected = $productRepository->find($jsonData['productId']);

        //get the amount of the quotation
        $amountQuotation = floatval($jsonData['price']);

        //create the quotation number
        $quotationNumber = date('Y') . '-' . date('m') . '-' . str_replace(' ', '', $clientSelected->getCompany()->getName()) . '-' . $faker->uuid();

        // create status of the quotation
        $statusQuotation = QuotationStatus::pending->value;

        //create quotation entity
        $quotation = new TechcareQuotation();
        $quotation->setClient($clientSelected);
        $quotation->setQuotationNumber($quotationNumber);
        $quotation->setAmount($amountQuotation);
        $quotation->setStatus($statusQuotation);
        $quotation->setDescription($jsonData['description']);
        $quotation->setCreatedBy($this->getUser()->getFirstname() . ' ' . $this->getUser()->getLastname());
        $quotation->setCreatedAt(new \DateTimeImmutable());

        $entityManager->persist($quotation);

        //create the quotation contents
        $quotationsContents = $jsonData['services'];
        foreach ($quotationsContents as $quotationContent) {
            $serviceSelect = $serviceRepository->find($quotationContent['serviceId']);

            $quotationContentEntity = new TechcareQuotationContent();
            $quotationContentEntity->setProduct($productSelected);
            $quotationContentEntity->setService($serviceSelect);
            if ($quotationContent['componentId'] != null) {
                $componentSelected = $componentsRepository->find($quotationContent['componentId']);
                $quotationContentEntity->setComponent($componentSelected);
            }
            $quotationContentEntity->setAmount($quotationContent['price']);
            $quotationContentEntity->setQuotation($quotation);

            $entityManager->persist($quotationContentEntity);
        }

        $entityManager->flush();

        //TODO: send email to the client

        //TODO: changer la redirection pour une redirection vers la page de la quotation manager (crud)
        // --> le faire dans le js avec window.location.href = '/quotation/manager' createQuotation.js

        $responseJson = json_encode(['status' => 'success', 'message' => 'all is good']);
        return new Response($responseJson, 200, ['Content-Type' => 'application/json']);
    }
}
