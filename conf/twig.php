<?php

use DI\Container;
use Slim\App;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

return static function (App $app) {
    // Create Twig
    $twig = Twig::create('../src/View', ['cache' => false]);

    // Add Twig-View Middleware
    $app->add(TwigMiddleware::create($app, $twig));

    // Add twig to container
    /** @var Container $container */
    $container = $app->getContainer();
    $container->set('twig', $twig);
};