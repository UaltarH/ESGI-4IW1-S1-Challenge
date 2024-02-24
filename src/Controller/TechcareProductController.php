<?php

namespace App\Controller;

use App\Entity\TechcareProduct;
use App\Form\TechcareProductType;
use App\Repository\TechcareProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/techcare/product')]
class TechcareProductController extends AbstractController
{
    #[Route('/', name: 'app_techcare_product_index', methods: ['GET'])]
    public function index(TechcareProductRepository $techcareProductRepository): Response
    {
        return $this->render('techcare_product/index.html.twig', [
            'techcare_products' => $techcareProductRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_techcare_product_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $techcareProduct = new TechcareProduct();
        $form = $this->createForm(TechcareProductType::class, $techcareProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($techcareProduct);
            $entityManager->flush();

            return $this->redirectToRoute('app_techcare_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('techcare_product/new.html.twig', [
            'techcare_product' => $techcareProduct,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_techcare_product_show', methods: ['GET'])]
    public function show(TechcareProduct $techcareProduct): Response
    {
        return $this->render('techcare_product/show.html.twig', [
            'techcare_product' => $techcareProduct,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_techcare_product_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TechcareProduct $techcareProduct, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TechcareProductType::class, $techcareProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_techcare_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('techcare_product/edit.html.twig', [
            'techcare_product' => $techcareProduct,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_techcare_product_delete', methods: ['POST'])]
    public function delete(Request $request, TechcareProduct $techcareProduct, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$techcareProduct->getId(), $request->request->get('_token'))) {
            $entityManager->remove($techcareProduct);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_techcare_product_index', [], Response::HTTP_SEE_OTHER);
    }
}
