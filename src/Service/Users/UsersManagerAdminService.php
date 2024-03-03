<?php

namespace App\Service\Users;

use App\Repository\TechcareUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use DateTimeImmutable;

class UsersManagerAdminService
{
    private TechcareUserRepository $techcareUserRepository;
    private EntityManagerInterface $entityManager;
    public function __construct(
        TechcareUserRepository $techcareUserRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->techcareUserRepository = $techcareUserRepository;
        $this->entityManager = $entityManager;
    }

    public function getUsers()
    {
        $usersFiltered = $this->techcareUserRepository->findUsersByRoles(['ROLE_COMPANY', 'ROLE_ACCOUNTANT', 'ROLE_OWNER_COMPANY']);
        $usersSorted = $this->sortUsersByUpdatedAt($usersFiltered);
        $usersFilteredMapped = array_map(function ($user) {
            $object = [
                'nom' => $user->getFirstname() . ' ' . $user->getLastname(),
                'email' => $user->getEmail(),
                'roles' => $user->getRolesAsArrayName(),
                'company' => $user->getCompany() ? $user->getCompany()->getName() : 'Aucune',
                'createdAt' => $user->getCreatedAt()->format('d/m/Y'),
                'actions' => [
                    'update' => [
                        'type' => 'button',
                        'path' => 'admin_user_update',
                        'label' => 'Modifier',
                        'id' => $user->getId(),
                    ]
                ]
            ];
            if (!in_array('ROLE_OWNER_COMPANY', $user->getRoles())) {
                $object['actions']['delete'] = [
                    'type' => 'form',
                    'path' => 'admin_user_delete',
                    'label' => 'Supprimer',
                    'id' => $user->getId(),
                ];
            }
            return $object;
        }, $usersSorted);

        //sort $usersFilteredMapped by updatedAt
        usort($usersFilteredMapped, function ($a, $b) {
            return $a['createdAt'] <=> $b['createdAt'];
        });

        $entityProperties = [
            'nom' => 'Prénom et nom',
            'email' => 'Email',
            'roles' => 'Rôles',
            'company' => 'Entreprise',
            'createdAt' => 'Date de création',
            'actions' => 'Actions',
        ];

        return [
            'datas' => $usersFilteredMapped,
            'entityProperties' => $entityProperties,
        ];
    }

    public function createUser($form, $userConnected, $newUser)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $newUser->setUpdatedAt(new \DateTimeImmutable());
            $newUser->setCreatedAt(new \DateTimeImmutable());
            $newUser->setCreatedBy($userConnected->getId());
            $newUser->setPassword(
                password_hash($form->get('password')->getData(), PASSWORD_BCRYPT)
            );
            $this->entityManager->persist($newUser);
            $this->entityManager->flush();

            // TODO : send mail 

            return true;
        }
        return false;
    }

    public function updateUser($form, $user, $userConnected)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setUpdatedAt(new \DateTimeImmutable());
            $user->setUpdatedBy($userConnected->getId());
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
