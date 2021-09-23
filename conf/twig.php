<?php

use Slim\App;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

return static function (App $app) {
    // Create Twig
    $twig = Twig::create('../src/View', ['cache' => false]);

    // Add Twig-View Middleware
    $app->add(TwigMiddleware::create($app, $twig));

    // Add twig to container
    $app->getContainer()->set('views', $twig);
};