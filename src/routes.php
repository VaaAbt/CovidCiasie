<?php
/** @var App $app */

use App\Controller\HomeController;
use Slim\App;

/**
 * ----------------
 * Routes
 * ----------------
 */
$app->get('/', [HomeController::class, 'index']);
