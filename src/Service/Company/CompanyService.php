<?php

namespace App\Service\Company;

use App\Repository\TechcareCompanyRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;


class CompanyService
{
    private TechcareCompanyRepository $companyRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(
        TechcareCompanyRepository $companyRepository,
        EntityManagerInterface $entityManager,
    ) {
        $this->companyRepository = $companyRepository;
        $this->entityManager = $entityManager;
    }

    public function manager()
    {
        $companies = $this->companyRepository->findAll();
        $companies = $this->sortCompaniesByDate($companies);

        $companiesMapped = array_map(function ($company) {
            return [
                'name' => $company->getName(),
                'name_owner' => $company->getOwner()->getFirstname() . ' ' . $company->getOwner()->getLastname(),
                'nombre_client' => count($company->getClient()),
                'nombre_user' => count($company->getUsers()),
                'email' => $company->getEmail(),
                'createdAt' => $company->getCreatedAt()->format('d/m/Y'),
                'active' => $company->isActive() ? 'Oui' : 'Non',
                'actions' => [
                    'update' => [
                        'type' => 'button',
                        'path' => 'company_edit',
                        'label' => 'Modifier',
                        'id' => $company->getId(),
                    ],
                    // 'delete' => [
                    //     'type' => 'form',
                    //     'path' => 'company_delete',
                    //     'label' => 'Supprimer',
                    //     'id' => $company->getId(),
                    // ],
                ]
            ];
        }, $companies);

        $entitiesProperties = [
            'name' => 'Nom',
            'name_owner' => 'Propriétaire',
            'nombre_client' => 'Clients',
            'nombre_user' => 'Utilisateurs',
            'email' => 'Email',
            'createdAt' => 'Créé le',
            'active' => 'Actif',
            'actions' => 'Actions',
        ];

        return [
            'datasTable' => $companiesMapped,
            'entityProperties' => $entitiesProperties,
        ];
    }

    public function editCompany($company, $form)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $company->setUpdatedAt(new DateTimeImmutable());
            $this->entityManager->flush();

            return true;
        }
        return false;
    }


    private function sortCompaniesByDate($companies)
    {
        usort($companies, function ($a, $b) {
            $updatedAtA = $a->getUpdatedAt() ?? new DateTimeImmutable('0000-00-00');
            $updatedAtB = $b->getUpdatedAt() ?? new DateTimeImmutable('0000-00-00');

            return $updatedAtB <=> $updatedAtA;
        });

        return $companies;
    }
}
