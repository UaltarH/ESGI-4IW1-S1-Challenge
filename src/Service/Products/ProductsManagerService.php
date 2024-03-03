<?php

namespace App\Service\Products;

use App\Repository\TechcareProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use DateTimeImmutable;


class ProductsManagerService
{
    private TechcareProductRepository $techcareProductRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(
        TechcareProductRepository $techcareProductRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->techcareProductRepository = $techcareProductRepository;
        $this->entityManager = $entityManager;
    }

    public function getProducts($userConnected)
    {
        $company = $userConnected->getCompany();
        $products = $this->techcareProductRepository->findBy(['company' => $company]);

        usort($products, function ($a, $b) {
            $updatedAtA = $a->getUpdatedAt() ?? new DateTimeImmutable('0000-00-00');
            $updatedAtB = $b->getUpdatedAt() ?? new DateTimeImmutable('0000-00-00');

            return $updatedAtB <=> $updatedAtA;
        });


        $productsMapped = array_map(function ($product) {
            return [
                'name' => $product->getName(),
                'brandName' => $product->getBrand()->getName(),
                'categoryName' => $product->getProductCategory()->getName(),
                'ArrayComponents' => $product->getComponents()->map(function ($component) {
                    return $component->getName();
                })->toArray(),
                'updatedAt' => $product->getUpdatedAt()->format('d/m/Y H:i'),
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

        $entityProperties = [
            'name' => 'Nom',
            'brandName' => 'Marque',
            'categoryName' => 'Catégorie',
            'ArrayComponents' => 'Composants',
            'updatedAt' => 'Dernière modification',
            'actions' => 'Actions',
        ];

        return [
            'datas' => $productsMapped,
            'entityProperties' => $entityProperties,
        ];
    }

    public function addProduct($form, $product, $userConnected)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $product->setUpdatedBy($userConnected->getFirstname() . ' ' . $userConnected->getLastname());
            $product->setCreatedAt(new \DateTimeImmutable());
            $product->setCreatedBy($userConnected->getFirstname() . ' ' . $userConnected->getLastname());
            $product->setUpdatedAt(new \DateTimeImmutable());
            $product->setCompany($userConnected->getCompany());

            $this->entityManager->persist($product);
            $this->entityManager->flush();
            return true;
        }
        return false;
    }

    public function editProduct($form, $product, $userConnected)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $product->setUpdatedBy($userConnected->getFirstname() . ' ' . $userConnected->getLastname());
            $product->setUpdatedAt(new \DateTimeImmutable());
            $this->entityManager->persist($product);
            $this->entityManager->flush();
            return true;
        }
        return false;
    }
}
