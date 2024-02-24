<?php

namespace App\Controller\Products;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Repository\TechcareProductRepository;
use App\Menu\MenuBuilder;
use App\Entity\TechcareProduct;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\Product\ProductsAddFormType;

class ProductsManagerController extends AbstractController
{
    #[Route('/products/manager', name: 'app_products_manager')]
    public function index(TechcareProductRepository $techcareProductRepository): Response
    {
        $products = $techcareProductRepository->findAll();
        $productsMapped = array_map(function ($product) {
            return [
                'name' => $product->getName(),
                'brandName' => $product->getBrand()->getName(),
                'categoryName' => $product->getProductCategory()->getName(),
                'ArrayStringComponents' => $product->getComponents()->map(function ($component) {
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
                'ArrayStringComponents' => 'Composants',
                'updatedAt' => 'Dernière modification',
                'actions' => 'Actions'
            ]
        ]);
    }

    #[Route('/products/manager/add', name: 'app_products_manager_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $techcareProduct = new TechcareProduct();
        $form = $this->createForm(ProductsAddFormType::class, $techcareProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //manque des setter 

            $entityManager->persist($techcareProduct);
            $entityManager->flush();

            return $this->redirectToRoute('app_products_manager', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('products_manager/new.html.twig', [
            'techcare_product' => $techcareProduct,
            'form' => $form,
        ]);
    }

    #[Route('/products/manager/edit/{id}', name: 'app_products_manager_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TechcareProduct $techcareProduct, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductsAddFormType::class, $techcareProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_products_manager', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('products_manager/edit.html.twig', [
            'techcare_product' => $techcareProduct,
            'form' => $form,
        ]);
    }

    #[Route('/products/manager/{id}', name: 'app_products_manager_delete', methods: ['POST'])]
    public function delete(Request $request, TechcareProduct $techcareProduct, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $techcareProduct->getId(), $request->request->get('_token'))) {
            $entityManager->remove($techcareProduct);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_products_manager', [], Response::HTTP_SEE_OTHER);
    }
}
