<?php

namespace App\Service;

use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

class UsersCompanyService
{
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function manager($userconnected)
    {
        $company = $userconnected->getCompany();
        $users = $company->getUsers()->toArray();
        $usersWithoutOwner = array_filter($users, function ($user) {
            return !in_array('ROLE_OWNER_COMPANY', $user->getRoles());
        });
        $usersWithoutOwner = $this->sortUsersByUpdatedAt($usersWithoutOwner);

        $usersMapped = array_map(function ($user) {
            return [
                'nom' => $user->getFirstname() . ' ' . $user->getLastname(),
                'email' => $user->getEmail(),
                'roles' => $user->getRolesAsArrayName(),
                'createdAt' => $user->getCreatedAt()->format('d/m/Y'),
                'actions' => [
                    'update' => [
                        'type' => 'button',
                        'path' => 'users_company_manager_update',
                        'label' => 'Modifier',
                        'id' => $user->getId(),
                    ],
                    'delete' => [
                        'type' => 'form',
                        'path' => 'users_company_manager_delete',
                        'label' => 'Supprimer',
                        'id' => $user->getId(),
                    ]
                ]
            ];
        }, $usersWithoutOwner);

        $entityProperties = [
            'nom' => 'Prenom et nom',
            'email' => 'Email',
            'roles' => 'Rôles',
            'createdAt' => 'Date de création',
            'actions' => 'Actions',
            'email' => 'Email',
        ];

        return [
            'entityProperties' => $entityProperties,
            'datas' => $usersMapped,
        ];
    }


    public function createUser($newUser, $form, $userconnected)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $newUser->setUpdatedAt(new \DateTimeImmutable());
            $newUser->setCreatedAt(new \DateTimeImmutable());
            $newUser->setCreatedBy($userconnected->getId());
            $newUser->setPassword(
                password_hash($form->get('password')->getData(), PASSWORD_BCRYPT)
            );
            $newUser->setCompany($userconnected->getCompany());

            $this->entityManager->persist($newUser);
            $this->entityManager->flush();

            return true;
        }
        return false;
    }

    public function updateUser($techcareUser, $form, $userconnected)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $techcareUser->setUpdatedAt(new \DateTimeImmutable());
            $techcareUser->setUpdatedBy($userconnected->getId());

            $this->entityManager->persist($techcareUser);
            $this->entityManager->flush();

            return true;
        }
        return false;
    }


    private function sortUsersByUpdatedAt($users)
    {
        usort($users, function ($a, $b) {
            $updatedAtA = $a->getUpdatedAt() ?? new DateTimeImmutable('0000-00-00');
            $updatedAtB = $b->getUpdatedAt() ?? new DateTimeImmutable('0000-00-00');

            return $updatedAtB <=> $updatedAtA;
        });

        return $users;
    }
}
