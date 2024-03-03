<?php

namespace App\Controller;

use App\Menu\MenuBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class ErrorController extends AbstractController
{
    public function show(FlattenException $exception, DebugLoggerInterface $logger = null): \Symfony\Component\HttpFoundation\Response
    {
        return match ($exception->getStatusCode()) {
            404 => $this->render('bundles/TwigBundle/Exception/error404.html.twig', [
                'menuItems' => (new MenuBuilder)->createMainMenu([
                    'connected' => false,
                ]),
                'footerItems' => (new MenuBuilder)->createMainFooter(),
                "code" => $exception->getStatusCode(),
                "message" => $exception->getStatusText()
            ]),
            403 => $this->render('bundles/TwigBundle/Exception/error403.html.twig', [
                'menuItems' => (new MenuBuilder)->createMainMenu([
                    'connected' => false,
                ]),
                'footerItems' => (new MenuBuilder)->createMainFooter(),
                "code" => $exception->getStatusCode(),
                "message" => $exception->getStatusText()
            ]),
            default => $this->render('bundles/TwigBundle/Exception/error.html.twig', [
                'menuItems' => (new MenuBuilder)->createMainMenu([
                    'connected' => false,
                ]),
                'footerItems' => (new MenuBuilder)->createMainFooter(),
                "code" => $exception->getStatusCode(),
                "message" => $exception->getStatusText()
            ]),
        };
    }
}