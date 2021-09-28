<?php
session_start();

use DI\Container;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container();
AppFactory::setContainer($container);
$app = AppFactory::create();

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

require __DIR__ . '/../conf/dependencies.php';
require __DIR__ . '/../conf/bootstrap.php';

require __DIR__ . '/../src/routes.php';

$app->run();
