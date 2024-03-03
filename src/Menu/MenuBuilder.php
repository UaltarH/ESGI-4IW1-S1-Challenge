<?php

namespace App\Menu;

class MenuBuilder
{
    public function createMainMenu(array $options = []): array
    {
        // maintenant on peut utiliser options pour afficher ou non certains items, eg : if ($options['show_admin']) $menu[] = ['label' => 'Admin','route' => 'admin_index',]; ..
        $menu = [];
        $menu[] = ['label' => 'Accueil', 'route' => 'default_index',];

        if (isset($options['connected']) && $options['connected']) {
            if(isset($options['role']) && $options['role'] === 'ROLE_ADMIN') {
                $menu[] = ['label' => 'Dashboard', 'route' => 'app_admin_dashboard_index',];
            } elseif(isset($options['role']) && ($options['role'] === 'ROLE_ACCOUNTANT') || ($options['role'] === 'ROLE_OWNER_COMPANY')){
                $menu[] = ['label' => 'Dashboard', 'route' => 'app_dashboard',];
            }
            switch ($options['role']) {
                case 'ROLE_ADMIN':
                    $menu[] = [
                        'label' => 'Admin', 'route' => '', 'children' => [
                            ['label' => 'Utilisateurs', 'route' => 'accueil_admin_users',],
                            ['label' => 'Entreprises', 'route' => 'company_manager',],
                        ],
                    ];
                    break;
                case 'ROLE_OWNER_COMPANY':
                    $menu[] = [
                        'label' => 'Admin', 'route' => '', 'children' => [
                            ['label' => 'Produits', 'route' => 'app_products_manager',],
                            ['label' => 'Clients', 'route' => 'app_client_list',],
                            ['label' => 'Employés', 'route' => 'users_company_manager',],
                        ],
                    ];
                    $menu[] = [
                        'label' => 'Procédures', 'route' => '', 'children' => [
                            ['label' => 'Devis', 'route' => 'app_quotation_manager',],
                            ['label' => 'Factures', 'route' => 'invoice_manager',],
                            ['label' => 'Paiement', 'route' => 'payement_list',],
                        ],
                    ];
                    break;
                case 'ROLE_ACCOUNTANT':
                    $menu[] = [
                        'label' => 'Procédures', 'route' => '', 'children' => [
                            ['label' => 'Devis', 'route' => 'app_quotation_manager',],
                            ['label' => 'Factures', 'route' => 'invoice_manager',],
                            ['label' => 'Paiement', 'route' => 'payement_list',],
                        ],
                    ];
                    break;
                case 'ROLE_COMPANY':
                    $menu[] = [
                        'label' => 'Gestion', 'route' => '', 'children' => [
                            ['label' => 'Produits', 'route' => 'app_products_manager',],
                            ['label' => 'Clients', 'route' => 'app_client_list',],
                        ],
                    ];
                    $menu[] = [
                        'label' => 'Procédures', 'route' => '', 'children' => [
                            ['label' => 'Devis', 'route' => 'app_quotation_manager',],
                            ['label' => 'Factures', 'route' => 'invoice_manager',],
                            ['label' => 'Paiement', 'route' => 'payement_list',],
                        ],
                    ];
                    break;
                default:
                    break;
            }
            $menu[] = [
                'label' => 'Mon compte', 'route' => '', 'children' => [
                    ['label' => 'Déconnexion', 'route' => 'app_logout',],
                ],
            ];
        } else {
            $menu[] = [
                'label' => 'Mon compte', 'route' => '', 'children' => [
                    ['label' => 'Connexion', 'route' => 'app_login',],
                    ['label' => 'Inscription', 'route' => 'app_register',],
                ],
            ];
        }
        return $menu;
    }
    public function createMainFooter(): array
    {
        return [
            ['label' => 'Mentions légales', 'route' => 'default_index',],
            ['label' => 'Contact', 'route' => 'default_index',],
            ['label' => 'CGV', 'route' => 'default_index',],
        ];
    }
}
