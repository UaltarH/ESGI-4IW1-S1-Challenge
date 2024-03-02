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
            $menu[] = ['label' => 'Dashboard', 'route' => 'app_dashboard',];
            $menu[] = [
                'label' => 'Admin', 'route' => '', 'children' => [
                    ['label' => 'Utilisateurs', 'route' => 'accueil_admin_users',],
                    ['label' => 'Produits', 'route' => 'app_products_manager',],
                    ['label' => 'Devis', 'route' => 'app_quotation_manager',],
                    ['label' => 'Clients', 'route' => 'app_client_list',],
                    ['label' => 'Factures', 'route' => 'invoice_manager',],
                    ['label' => 'Payement', 'route' => 'payement_list',],

                ],
            ];
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
