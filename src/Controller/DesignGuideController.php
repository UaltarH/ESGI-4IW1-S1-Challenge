<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DesignGuideController extends AbstractController
{
    public function index()
    {
        return $this->render('design_guide/index.html.twig', [
            'controller_name' => 'DesignGuideController',
        ]);
    }
}