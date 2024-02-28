<?php

namespace App\Menu;
class MenuBuilder {
    public function createMainMenu(array $options = []): array
    {
        // maintenant on peut utiliser options pour afficher ou non certains items, eg : if ($options['show_admin']) $menu[] = ['label' => 'Admin','route' => 'admin_index',]; ..
        $menu = [];
        $menu[] = ['label' => 'Accueil','route' => 'default_index',];
        if (isset($options['connected']) && $options['connected']) {
            $menu[] = ['label' => 'Dashboard','route' => 'app_dashboard',];
            $menu[] = ['label' => 'Produits','route' => 'app_products_manager',];
            $menu[] = ['label' => 'Utilisateurs','route' => 'accueil_admin_users',];
            $menu[] = ['label' => 'Devis','route' => 'app_quotation',];
            $menu[] = ['label' => 'Déconnexion','route' => 'app_logout',];
        }
        else {
            $menu[] = ['label' => 'Inscription','route' => 'app_register',];
            $menu[] = ['label' => 'Connexion','route' => 'app_login',];
        }
        return $menu;
    }
}