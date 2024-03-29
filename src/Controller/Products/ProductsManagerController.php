<?php

namespace App\Controller\Products;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Menu\MenuBuilder;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\TechcareProduct;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\Product\ProductsAddAndUpdateType;
use App\Service\Products\ProductsManagerService;
use App\Entity\TechcareQuotationContent;
use App\Entity\TechcarePayment;
use App\Entity\TechcareInvoice;

class ProductsManagerController extends AbstractController
{
    private ProductsManagerService $productsManagerService;

    public function __construct(
        ProductsManagerService $productsManagerService
    ) {
        $this->productsManagerService = $productsManagerService;
    }

    #[Route('/products/manager', name: 'app_products_manager')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_COMPANY');

        $userConnected = $this->getUser();
        $datas = $this->productsManagerService->getProducts($userConnected);

        return $this->render('employee/products_manager/index.html.twig', [
            'menuItems' => (new MenuBuilder)->createMainMenu([
                'connected' => $userConnected instanceof UserInterface,
                'role' => $userConnected->getRoles()[0],
            ]),
            'footerItems' => (new MenuBuilder)->createMainFooter(),
            'company' => $userConnected->getCompany()->getName(),
            'controller_name' => 'ProductsManagerController',
            'datas' => $datas['datas'],
            'title' => 'Gestion des produits',
            'entityProperties' => $datas['entityProperties'],
        ]);
    }

    #[Route('/products/manager/add', name: 'app_products_manager_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_COMPANY');
        $userConnected = $this->getUser();
        $techcareProduct = new TechcareProduct();
        $form = $this->createForm(ProductsAddAndUpdateType::class, $techcareProduct);
        $form->handleRequest($request);

        $bool = $this->productsManagerService->addProduct($form, $techcareProduct, $userConnected);

        if ($bool) {
            $this->addFlash('success', 'Nouveau produit ajouté avec succès !');
            return $this->redirectToRoute('app_products_manager');
        } else {
            return $this->render('employee/products_manager/new.html.twig', [
                'menuItems' => (new MenuBuilder)->createMainMenu([
                    'connected' => $userConnected instanceof UserInterface,
                    'role' => $userConnected->getRoles()[0],
                ]),
                'footerItems' => (new MenuBuilder)->createMainFooter(),
                'company' => $userConnected->getCompany()->getName(),
                'form' => $form->createView(),
            ]);
        }
    }

    #[Route('/products/manager/edit/{id}', name: 'app_products_manager_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TechcareProduct $techcareProduct): Response | Exception
    {
        $this->denyAccessUnlessGranted('ROLE_COMPANY');
        $userConnected = $this->getUser();
        if ($techcareProduct->getCompany() !== $userConnected->getCompany()) {
            return $this->createAccessDeniedException("Vous n'avez pas le droit de modifier ce produit");
        }
        $componentsOftheProduct = $techcareProduct->getComponents()->toArray();
        //meme si on specifie componentsList en mapped false, il vas quand meme lié les composants au produit car les composants qu'on lui fourni sont deja lié au produit qu'on modifie
        $form = $this->createForm(ProductsAddAndUpdateType::class, $techcareProduct, ['componentsList' => $componentsOftheProduct]);
        $form->handleRequest($request);

        $bool = $this->productsManagerService->editProduct($form, $techcareProduct, $userConnected);

        if ($bool) {
            $this->addFlash('success', 'Produit modifié avec succès !');
            return $this->redirectToRoute('app_products_manager');
        } else {
            return $this->render('employee/products_manager/edit.html.twig', [
                'menuItems' => (new MenuBuilder)->createMainMenu([
                    'connected' => $userConnected instanceof UserInterface,
                    'role' => $userConnected->getRoles()[0],
                ]),
                'footerItems' => (new MenuBuilder)->createMainFooter(),
                'company' => $userConnected->getCompany()->getName(),
                'form' => $form->createView(),
            ]);
        }
    }

    #[Route('/products/manager/delete/{id}', name: 'app_products_manager_delete', methods: ['POST'])]
    public function delete(Request $request, TechcareProduct $techcareProduct, EntityManagerInterface $entityManager): Response | Exception
    {
        $this->denyAccessUnlessGranted('ROLE_COMPANY');
        if ($techcareProduct->getCompany() !== $this->getUser()->getCompany()) {
            return $this->createAccessDeniedException("Vous n'avez pas le droit de supprimer ce produit");
        }
        if ($this->isCsrfTokenValid('delete' . $techcareProduct->getId(), $request->request->get('_token'))) {

            //TODO: change database schema 
            $quotationsToRemove = [];
            //remove all quotations contents related to this product
            $quotationsContents = $entityManager->getRepository(TechcareQuotationContent::class)->findBy(['product' => $techcareProduct]);
            foreach ($quotationsContents as $quotationContent) {
                $quotationsToRemove[] = $quotationContent->getQuotation();
                $entityManager->remove($quotationContent);
            }

            //remove all quotations related to this product
            foreach ($quotationsToRemove as $quotation) {
                //remove all payements related to this quotation
                $payements = $entityManager->getRepository(TechcarePayment::class)->findBy(['quotation' => $quotation]);
                foreach ($payements as $payement) {
                    //remova all invoices related to this payement
                    $invoices = $entityManager->getRepository(TechcareInvoice::class)->findBy(['payment' => $payement]);
                    foreach ($invoices as $invoice) {
                        $entityManager->remove($invoice);
                    }

                    $entityManager->remove($payement);
                }

                $entityManager->remove($quotation);
            }

            $entityManager->remove($techcareProduct);

            $entityManager->flush();
        }
        $this->addFlash('success', 'Produit supprimé avec succès !');
        return $this->redirectToRoute('app_products_manager', [], Response::HTTP_SEE_OTHER);
    }
}
