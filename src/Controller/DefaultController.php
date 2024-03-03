<?php
namespace App\Controller;
use App\Menu\MenuBuilder;
use App\Repository\TechcareCompanyRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DefaultController extends AbstractController
{
    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    #[Route('/', name: 'default_index')]
    public function index(TechcareCompanyRepository $companyRepository): Response
    {
        $connected = $this->getUser() instanceof UserInterface;
        return $this->render('default/index.html.twig', [
            'menuItems' => (new MenuBuilder)->createMainMenu([
                'connected' => $connected,
                'role' => $connected ? $this->getUser()->getRoles()[0] : null,
            ]),
            'footerItems' => (new MenuBuilder)->createMainFooter(),
            'company' => $connected ? $this->getUser()->getCompany()->getName() : null,
            'totalCompanies' => $companyRepository->countCompanies(),
        ]);
    }
}