<?php

namespace App\Service\Quotation;

use App\Entity\TechcareQuotation;
use App\Entity\TechcareQuotationContent;
use App\Repository\TechcareQuotationRepository;
use App\Utilities\QuotationUtils;
use App\Enum\QuotationStatus;
use App\Repository\TechcareClientRepository;
use App\Repository\TechcareServiceRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TechcareComponentRepository;
use App\Repository\TechcareProductRepository;
use Faker\Factory;
use Twig\Environment;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Utilities\EmailUtils;
use App\Utilities\PdfUtils;


class QuotationManagerService
{
    private TechcareQuotationRepository $quotationRepository;
    private QuotationUtils $quotationUtils;
    private EntityManagerInterface $entityManager;
    private TechcareServiceRepository $serviceRepository;
    private TechcareComponentRepository $componentsRepository;
    private TechcareClientRepository $clientRepository;
    private TechcareProductRepository $productRepository;
    private Environment $twig;
    private EmailUtils $emailUtils;
    private PdfUtils $pdfUtils;
    private UrlGeneratorInterface $router;

    public function __construct(
        Environment $twig,
        UrlGeneratorInterface $router,
        PdfUtils $pdfUtils,
        EmailUtils $emailUtils,
        TechcareProductRepository $productRepository,
        TechcareClientRepository $clientRepository,
        TechcareComponentRepository $componentsRepository,
        TechcareServiceRepository $serviceRepository,
        EntityManagerInterface $entityManager,
        TechcareQuotationRepository $techcareQuotationRepository,
        QuotationUtils $quotationUtils
    ) {
        $this->quotationRepository = $techcareQuotationRepository;
        $this->quotationUtils = $quotationUtils;
        $this->entityManager = $entityManager;
        $this->serviceRepository = $serviceRepository;
        $this->componentsRepository = $componentsRepository;
        $this->clientRepository = $clientRepository;
        $this->productRepository = $productRepository;
        $this->emailUtils = $emailUtils;
        $this->pdfUtils = $pdfUtils;
        $this->router = $router;
        $this->twig = $twig;
    }

    public function manager($userConnected)
    {
        $company = $userConnected->getCompany();
        $clientsCompany = $company->getClient();

        //get all quotations for this company
        $quotations = [];
        foreach ($clientsCompany as $client) {
            $quotations = array_merge($quotations, $this->quotationRepository->findBy(['client' => $client]));
        }

        $quotationsSorted = $this->quotationUtils->sortQuotationsByDate($quotations);

        $datas = $this->quotationUtils->getArrayEntityMappedUsedForTable($quotationsSorted);

        return [
            'datas' => $datas,
            'entityProperties' => [
                'quotation_number' => 'Numéro de devis',
                'client' => 'Client',
                'created_by' => 'Créé par',
                'last_modif' => 'Dernière modification',
                'amount' => 'Montant',
                'status' => 'Statut',
                'actions' => 'Actions',
            ],
        ];
    }

    public function showQuotation($quotation)
    {
        return $this->quotationUtils->prepareDataForPdfOrPreview($quotation);
    }

    public function editQuotation($quotation, $userConnected)
    {
        $company = $userConnected->getCompany();

        $datas = $this->quotationUtils->getDatasForCreatAndEditQuotation($company);

        //using for editing quotation
        $discountValue = 0;
        if ($quotation->getDiscount() != null) {
            $discountValue = $quotation->getDiscount();
        }


        $arrayQuotationContent = $quotation->getContents();
        $priceAllContent = 0;
        foreach ($arrayQuotationContent as $content) {
            if ($content instanceof TechcareQuotationContent) {
                $priceAllContent = $priceAllContent + $content->getAmount();
            }
        }
        $priceAllContentTTC = $priceAllContent * 1.2;

        $amountFinal = 0;
        if ($discountValue == 0) {
            $amountFinal = $priceAllContentTTC;
        } else {
            $discount = ($priceAllContentTTC * $discountValue) / 100;
            $amountFinal = $priceAllContentTTC - $discount;
        }

        $quotationContentsMapped = [];
        $quotationContents = $quotation->getContents();
        foreach ($quotationContents as $content) {
            $quotationContentsMapped[] = [
                'service_id' => $content->getService()->getId(),
                'service_name' => $content->getService()->getName(),
                'component_id' => $content->getComponent() !== null ? $content->getComponent()->getId() : null,
                'component_name' => $content->getComponent() !== null ? $content->getComponent()->getName() : null,
                'amount' => $content->getAmount(),
            ];
        }


        $quotationToEdit = [
            'number' => $quotation->getQuotationNumber(),
            'client_id' => $quotation->getId(),
            'client_name' => $quotation->getClient()->getFirstname() . ' ' . $quotation->getClient()->getLastname(),
            'product_id' => $quotation->getContents()[0]->getProduct()->getId(),
            'product_name' => $quotation->getContents()[0]->getProduct()->getName(),
            'quotation_description' => $quotation->getDescription(),
            'quotation_discount' => $discountValue,
            'quotation_contentsTotalPriceHt' => $priceAllContent,
            'quotation_contentsTotalPriceTTC' => $priceAllContentTTC,
            'quotation_amount' => $amountFinal,
            'quotation_contents' => $quotationContentsMapped,
        ];

        return [
            'datas' => $datas,
            'quotation' => $quotationToEdit,
        ];
    }

    public function editPostQuotation($jsonData, $userConnected)
    {
        $quotation = $this->quotationRepository->find($jsonData['id']);
        $quotation->setDescription($jsonData['description']);
        $quotation->setDiscount($jsonData['discount']);
        $quotation->setAmount($jsonData['price']);
        $quotation->setUpdatedAt(new DateTimeImmutable());
        $quotation->setUpdatedBy($userConnected->getFirstname() . ' ' . $userConnected->getLastname());

        $productQuotation = $quotation->getContents()[0]->getProduct();

        // delete all contents of the quotation and create new ones
        $contents = $quotation->getContents();
        foreach ($contents as $content) {
            $quotation->removeContent($content);
        }
        $this->entityManager->flush();

        $quotationsContents = $jsonData['services'];
        foreach ($quotationsContents as $content) {
            $quotationContent = new TechcareQuotationContent();
            $quotationContent->setProduct($productQuotation);
            $quotationContent->setService($this->serviceRepository->find($content['serviceId']));
            $quotationContent->setAmount($content['price']);
            $quotationContent->setQuotation($quotation);
            if ($content['componentId'] !== null) {
                $quotationContent->setComponent($this->componentsRepository->find($content['componentId']));
            }
            $this->entityManager->persist($quotationContent);
        }

        $this->entityManager->flush();

        return [
            'status' => 'success',
            'message' => 'all is good',
            'quotationId' => $quotation->getId(),
        ];
    }

    public function createQuotation($userConnected)
    {
        $company = $userConnected->getCompany();
        return $this->quotationUtils->getDatasForCreatAndEditQuotation($company);
    }

    public function createPostQuotation($jsonData, $userConnected)
    {
        $faker = Factory::create('fr_FR');

        //get entities with the json data
        $clientSelected = $this->clientRepository->find($jsonData['clientId']);
        $productSelected = $this->productRepository->find($jsonData['productId']);

        //get the discount value 
        $discount = floatval($jsonData['discount']);

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
        $quotation->setDiscount($discount);
        $quotation->setCreatedBy($userConnected->getFirstname() . ' ' . $userConnected->getLastname());
        $quotation->setCreatedAt(new \DateTimeImmutable());
        $quotation->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($quotation);

        //create the quotation contents
        $quotationsContents = $jsonData['services'];
        foreach ($quotationsContents as $quotationContent) {
            $serviceSelect = $this->serviceRepository->find($quotationContent['serviceId']);

            $quotationContentEntity = new TechcareQuotationContent();
            $quotationContentEntity->setProduct($productSelected);
            $quotationContentEntity->setService($serviceSelect);
            if ($quotationContent['componentId'] != null) {
                $componentSelected = $this->componentsRepository->find($quotationContent['componentId']);
                $quotationContentEntity->setComponent($componentSelected);
            }
            $quotationContentEntity->setAmount($quotationContent['price']);
            $quotationContentEntity->setQuotation($quotation);

            $this->entityManager->persist($quotationContentEntity);
        }

        $this->entityManager->flush();

        return [
            'status' => 'success',
            'message' => 'all is good',
            'quotationId' => $quotation->getId()
        ];
    }

    public function sendPdf($quotation)
    {
        $clientEmail = $quotation->getClient()->getEmail();

        //set token to the quotation using for security of the links in the email.
        //this token will be used to accept or refuse the quotation and it will be delete after the action (accept / refuse) of the client
        $quotation->generateToken();
        $this->entityManager->flush();


        $data = $this->quotationUtils->prepareDataForPdfOrPreview($quotation);

        $html =  $this->twig->render('pdfTemplates/quotation.html.twig', $data);

        $contentPdf = $this->pdfUtils->generatePdfFile($html);

        $acceptUrl = $this->router->generate('app_quotation_accept', ['token' => $quotation->getToken()], UrlGeneratorInterface::ABSOLUTE_URL);
        $refuseUrl = $this->router->generate('app_quotation_refuse', ['token' => $quotation->getToken()], UrlGeneratorInterface::ABSOLUTE_URL);
        $htmlContent = '<p>Veuillez cliquer sur le lien ci-dessous pour accepter le devis :</p><br><a href="' . $acceptUrl . '">Accepter le devis</a> <br>';
        $htmlContent .= '<p>Veuillez cliquer sur le lien ci-dessous pour refuser le devis :</p><br><a href="' . $refuseUrl . '">Refuser le devis</a> ';

        //for brevo
        $clientFullName = $quotation->getClient()->getFirstname() . ' ' . $quotation->getClient()->getLastname();
        $dateQuotation = $quotation->getCreatedAt()->format('d/m/Y');
        $companyName = $quotation->getClient()->getCompany()->getName();
        $quoteName = $quotation->getQuotationNumber();



        $this->emailUtils->sendEmailWithPdf('subject', $htmlContent, 'mail@gmail.com', $clientEmail, $contentPdf, $data['quotation_number']);

        $this->emailUtils->sendEmailForQuoteUsingBrevo(
            "admin",
            "admin@techcare.com",
            "mathieupannetrat5@gmail.com", // $clientEmail,
            $clientFullName,
            $dateQuotation,
            $companyName,
            base64_encode($contentPdf),
            $quoteName . '.pdf',
            $acceptUrl,
            $refuseUrl
        );
    }

    public function acceptQuotation($token)
    {
        $quotation = $this->quotationRepository->findOneBy(['token' => $token]);

        if ($quotation === null) {
            return [
                'status' => 'error',
                'message' => 'error message'
            ];
        } else {
            $quotation->setStatus(QuotationStatus::accepted->value);
            $quotation->setToken(null);
            $this->entityManager->flush();

            return [
                'status' => 'success',
                'message' => 'all is good',
                'quotationNumber' => $quotation->getQuotationNumber()
            ];
        }
    }

    public function refuseQuotation($token)
    {
        $quotation = $this->quotationRepository->findOneBy(['token' => $token]);

        if ($quotation === null) {
            return [
                'status' => 'error',
                'message' => 'error message'
            ];
        } else {
            $quotation->setStatus(QuotationStatus::refused->value);
            $quotation->setToken(null);
            $this->entityManager->flush();

            return [
                'status' => 'success',
                'message' => 'all is good',
                'quotationNumber' => $quotation->getQuotationNumber()
            ];
        }
    }
}
