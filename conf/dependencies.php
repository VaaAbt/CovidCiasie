<?php

/** @var App $app */

use Slim\App;

$container = $app->getContainer();

//Twig
//$container['view'] = function ($container) {
//    $view = new \Slim\Views\Twig(__DIR__ . '/../src/views', $container['twig_settings']);
//    $env = $view->getEnvironment();
//
//    $view->addExtension(new \Twig\Extension\DebugExtension());
//    $view->addExtension(new Slim\Views\TwigExtension(
//        $container->router,
//        $container['request']->getUri()
//    ));
//
//    // adding global param to twig views
//    // $env->addGlobal('name', $container->name);
//    return $view;
//};
