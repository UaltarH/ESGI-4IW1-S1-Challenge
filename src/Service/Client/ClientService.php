<?php

namespace App\Service\Client;

use App\Entity\TechcareClient;
use App\Repository\TechcareClientRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;


class ClientService
{
    private TechcareClientRepository $clientRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(
        TechcareClientRepository $clientRepository,
        EntityManagerInterface $entityManager,
    ) {
        $this->clientRepository = $clientRepository;
        $this->entityManager = $entityManager;
    }

    public function getClientList($userConnected)
    {
        $company = $userConnected->getCompany();
        $clients = $this->clientRepository->findBy(['company' => $company]);

        usort($clients, function ($a, $b) {
            $updatedAtA = $a->getUpdatedAt() ?? new DateTimeImmutable('0000-00-00');
            $updatedAtB = $b->getUpdatedAt() ?? new DateTimeImmutable('0000-00-00');

            return $updatedAtB <=> $updatedAtA;
        });

        $clientsMap = array_map(function ($client) {
            return [
                'fullName' => $client->getFirstname() . ' ' . $client->getLastname(),
                'email' => $client->getEmail(),
                'billingAddress' => $client->getBillingAddress(),
                'phoneNumber' => $client->getPhoneNumber(),
                'updatedAt' => $client->getUpdatedAt()->format('d/m/Y H:i '),
                'actions' => [
                    'update' => [
                        'type' => 'button',
                        'path' => 'app_client_edit',
                        'label' => 'Modifier',
                        'id' => $client->getId(),
                    ],
                    'delete' => [
                        'type' => 'form',
                        'path' => 'app_client_delete',
                        'label' => 'Supprimer',
                        'id' => $client->getId(),
                    ]
                ]
            ];
        }, $clients);

        $entityProperties = [
            'fullName' => 'Nom',
            'email' => 'E-mail',
            'billingAddress' => 'Adresse de facturation',
            'phoneNumber' => 'N° de téléphone',
            'updatedAt' => 'Dernière modification',
            'actions' => 'Actions'
        ];
        return [
            'datas' => $clientsMap,
            'entityProperties' => $entityProperties,
        ];
    }

    public function updateClient($client, $form, $userConnected)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $client->setUpdatedBy($userConnected->getFirstname() . ' ' . $userConnected->getLastname());
            $client->setUpdatedAt(new \DateTimeImmutable());
            $this->entityManager->persist($client);
            $this->entityManager->flush();
            return true;
        }
        return false;
    }

    public function addClient($newClient, $userConnected, $form)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $newClient->setUpdatedBy($userConnected->getFirstname() . ' ' . $userConnected->getLastname());
            $newClient->setCreatedBy($userConnected->getFirstname() . ' ' . $userConnected->getLastname());
            $newClient->setUpdatedAt(new \DateTimeImmutable());
            $newClient->setCreatedAt(new \DateTimeImmutable());
            $newClient->setCompany($userConnected->getCompany());
            $this->entityManager->persist($newClient);
            $this->entityManager->flush();
            return true;
        }
        return false;
    }
}
