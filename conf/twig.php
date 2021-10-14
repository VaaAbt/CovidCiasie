<?php

use App\Utils\Auth;
use DI\Container;
use Slim\App;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

return static function (App $app) {
    // Create Twig
    $twig = Twig::create('../src/View', ['cache' => false]);

    // Add Twig-View Middleware
    $app->add(TwigMiddleware::create($app, $twig));

    // Add Twig session variable
    $environment = $twig->getEnvironment();
    $environment->addGlobal('auth', (object)[
        'isLoggedIn' => Auth::isLoggedIn(),
        'user' => Auth::getUser()
    ]);

    // Add twig to container
    /** @var Container $container */
    $container = $app->getContainer();
    $container->set('twig', $twig);
};