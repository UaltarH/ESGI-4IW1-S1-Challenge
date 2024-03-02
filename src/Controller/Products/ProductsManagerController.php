<?php

namespace App\Controller\Products;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Repository\TechcareProductRepository;
use App\Menu\MenuBuilder;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\TechcareProduct;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\Product\ProductsAddAndUpdateType;
use App\Entity\TechcareProductComponentPrice;
use App\Form\ProductComponentPrice\ProductComponentPriceType;
use App\Repository\TechcareComponentRepository;
use App\Repository\TechcareProductComponentPriceRepository;

class ProductsManagerController extends AbstractController
{
    #[Route('/products/manager', name: 'app_products_manager')]
    public function index(TechcareProductRepository $techcareProductRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_COMPANY');
        $company = $this->getUser()->getCompany();
        $products = $techcareProductRepository->findBy(['company' => $company]);
        $productsMapped = array_map(function ($product) {
            return [
                'name' => $product->getName(),
                'brandName' => $product->getBrand()->getName(),
                'categoryName' => $product->getProductCategory()->getName(),
                'ArrayComponents' => $product->getComponents()->map(function ($component) {
                    return $component->getName();
                })->toArray(),
                'updatedAt' => $product->getUpdatedAt()->format('d/m/Y H:i:s'),
                'actions' => [
                    'update' => [
                        'type' => 'button',
                        'path' => 'app_products_manager_edit',
                        'label' => 'Modifier',
                        'id' => $product->getId(),
                    ],
                    'delete' => [
                        'type' => 'form',
                        'path' => 'app_products_manager_delete',
                        'label' => 'Supprimer',
                        'id' => $product->getId(),
                    ]
                ]
            ];
        }, $products);

        $userConnected = $this->getUser() instanceof UserInterface;

        return $this->render('products_manager/index.html.twig', [
            'menuItems' => (new MenuBuilder)->createMainMenu(['connected' => $userConnected]),
            'controller_name' => 'ProductsManagerController',
            'datas' => $productsMapped,
            'title' => 'Gestion des produits',
            'entityProperties' => [
                'name' => 'Nom',
                'brandName' => 'Marque',
                'categoryName' => 'Catégorie',
                'ArrayComponents' => 'Composants',
                'updatedAt' => 'Dernière modification',
                'actions' => 'Actions'
            ]
        ]);
    }

    #[Route('/products/manager/add', name: 'app_products_manager_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $userConnected = $this->getUser() instanceof UserInterface;
        $techcareProduct = new TechcareProduct();
        $form = $this->createForm(ProductsAddAndUpdateType::class, $techcareProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $techcareProduct->setUpdatedBy($this->getUser()->getFirstname() . ' ' . $this->getUser()->getLastname());
            $techcareProduct->setCreatedAt(new \DateTimeImmutable());
            $techcareProduct->setCreatedBy($this->getUser()->getFirstname() . ' ' . $this->getUser()->getLastname());
            $techcareProduct->setUpdatedAt(new \DateTimeImmutable());
            $techcareProduct->setCompany($this->getUser()->getCompany());

            $entityManager->persist($techcareProduct);
            $entityManager->flush();
            return $this->redirectToRoute('app_products_manager');
        }

        return $this->render('products_manager/new.html.twig', [
            'menuItems' => (new MenuBuilder)->createMainMenu(['connected' => $userConnected]),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/products/manager/edit/{id}', name: 'app_products_manager_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TechcareProduct $techcareProduct, EntityManagerInterface $entityManager): Response
    {
        $userConnected = $this->getUser() instanceof UserInterface;
        $componentsOftheProduct = $techcareProduct->getComponents()->toArray();
        //meme si on specifie componentsList en mapped false, il vas quand meme lié les composants au produit car les composants qu'on lui fourni sont deja lié au produit qu'on modifie
        $form = $this->createForm(ProductsAddAndUpdateType::class, $techcareProduct, ['componentsList' => $componentsOftheProduct]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $techcareProduct->setUpdatedBy($this->getUser()->getFirstname() . ' ' . $this->getUser()->getLastname());
            $techcareProduct->setUpdatedAt(new \DateTimeImmutable());

            $entityManager->persist($techcareProduct);
            $entityManager->flush();
            return $this->redirectToRoute('app_products_manager');
        }

        return $this->render('products_manager/edit.html.twig', [
            'menuItems' => (new MenuBuilder)->createMainMenu(['connected' => $userConnected]),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/products/manager/delete/{id}', name: 'app_products_manager_delete', methods: ['POST'])]
    public function delete(Request $request, TechcareProduct $techcareProduct, EntityManagerInterface $entityManager, TechcareProductComponentPriceRepository $techcareProductComponentPriceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $techcareProduct->getId(), $request->request->get('_token'))) {
            $entityManager->remove($techcareProduct);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_products_manager', [], Response::HTTP_SEE_OTHER);
    }


    //n'est plus utilisé 
    // #[Route('/products/manager/add/component/{id}', name: 'app_products_manager_add_component', methods: ['GET'])]
    // public function addComponent(TechcareProduct $techcareProduct, TechcareComponentRepository $techcareComponentRepository): Response
    // {
    //     $allComponents = $techcareComponentRepository->findAll();
    //     $allComponentsMapped = array_map(function ($component) {
    //         return [
    //             'id' => $component->getId(),
    //             'name' => $component->getName(),
    //             'price' => 1,
    //             'checked' => false,
    //         ];
    //     }, $allComponents);
    //     return $this->render('products_manager/componentsProductManage.html.twig', [
    //         'components' => $allComponentsMapped,
    //         'productName' => $techcareProduct->getName(),
    //     ]);
    // }


    // #[Route('/products/manager/edit/components/{id}', name: 'app_products_manager_edit_components', methods: ['GET'])]
    // public function editComponents(TechcareProduct $techcareProduct, TechcareComponentRepository $techcareComponentRepository): Response
    // {
    //     $productComponentPriceObjects = $techcareProduct->getTechcareProductComponentPrices();
    //     $productComponents = $productComponentPriceObjects->map(function ($componentProductPrice) {
    //         $componentsId = $componentProductPrice->getComponentId();
    //         foreach ($componentsId as $componentId) {
    //             return [
    //                 'id' => $componentId->getId(),
    //                 'name' => $componentId->getName(),
    //                 'price' => $componentProductPrice->getPrice(),
    //                 'checked' => true,
    //             ];
    //         }
    //     })->toArray();

    //     return $this->render('products_manager/componentsProductManage.html.twig', [
    //         'components' => $productComponents,
    //         'productName' => $techcareProduct->getName(),
    //     ]);
    // }

    // #[Route('/products/manager/componentpost', name: 'app_products_manager_add_component_post', methods: ['POST', 'GET'])]
    // public function addComponentPost(Request $request, EntityManagerInterface $entityManager, TechcareProductRepository $techcareProductRepository, TechcareComponentRepository $techcareComponentRepository): Response
    // {
    //     $jsonContent = $request->getContent();
    //     $dataArray = json_decode($jsonContent, true);

    //     $newComponentsSelected = $dataArray['components'];
    //     $techcareProduct = $techcareProductRepository->find($dataArray['product']);

    //     if (is_iterable($newComponentsSelected)) {
    //         foreach ($newComponentsSelected as $componentId => $componentPrice) {
    //             //clear the previous components associated with the product
    //             $productComponentPriceObjects = $techcareProduct->getTechcareProductComponentPrices();
    //             foreach ($productComponentPriceObjects as $productComponentPriceObject) {
    //                 $entityManager->remove($productComponentPriceObject);
    //             }

    //             //add the new components
    //             $techcareProductComponentPrice = new TechcareProductComponentPrice();

    //             $componentObject = $techcareComponentRepository->find($componentId);

    //             $techcareProductComponentPrice->addComponentId($componentObject);
    //             $techcareProductComponentPrice->addProductId($techcareProduct);
    //             $techcareProductComponentPrice->setPrice($componentPrice);

    //             $entityManager->persist($techcareProductComponentPrice);
    //         }
    //         $entityManager->flush();
    //         $responseJson = json_encode(['status' => 'success', 'message' => 'Composants ajoutés avec succès']);
    //         return new Response($responseJson, 200, ['Content-Type' => 'application/json']);
    //     }
    // }
}
