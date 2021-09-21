<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

require __DIR__ . '/../conf/dependencies.php';
require __DIR__ . '/../conf/dbConnection.php';

require __DIR__ . '/../src/routes.php';

$app->run();
