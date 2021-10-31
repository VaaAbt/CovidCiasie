<?php
session_start();

use App\Middleware\CORSMiddleware;
use DI\Container;
use Slim\Csrf\Guard;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container();
AppFactory::setContainer($container);
$app = AppFactory::create();

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$responseFactory = $app->getResponseFactory();

// Register Middleware On Container
$container->set('csrf', function () use ($responseFactory) {
    return new Guard($responseFactory);
});

// Register Middleware To Be Executed On All Routes
$app->add('csrf');

// CORS
$app->add(new CORSMiddleware());

require __DIR__ . '/../conf/dependencies.php';
require __DIR__ . '/../conf/bootstrap.php';

require __DIR__ . '/../src/routes.php';

$app->run();
