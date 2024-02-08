<?php

namespace App\Menu;
class MenuBuilder {
    public function createMainMenu(array $options = []): array
    {
        // maintenant on peut utiliser options pour afficher ou non certains items, eg : if ($options['show_admin']) $menu[] = ['label' => 'Admin','route' => 'admin_index',]; ..
        $menu = [];
        $menu[] = ['label' => 'Accueil','route' => 'app_home',];
        $menu[] = ['label' => 'Inscription','route' => 'app_register',];
        $menu[] = ['label' => 'Connexion','route' => 'app_login',];
        $menu[] = ['label' => 'Déconnexion','route' => 'app_logout',];
        $menu[] = ['label' => 'Default','route' => 'default_index',];
        if (isset($options['connected']) && $options['connected']) {
            $menu[] = ['label' => 'Devis','route' => 'app_quotation',];
        }
        return $menu;
    }
}