<?php

/** @var Slim\App $app */
/** @var DI\Container $container */
$container = $app->getContainer();

$container->set('settings', require('settings.php'));