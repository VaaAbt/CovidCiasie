<?php
/** @var App $app */

use App\Controller\HomeController;
use App\Controller\MessageController;
use Slim\App;

/**
 * ----------------
 * Routes
 * ----------------
 */
$app->get('/', [HomeController::class, 'index']);

// chat building
$app->get('/chat/{user_id}', [MessageController::class, 'getChat']);
$app->post('/chat/{user_id}', [MessageController::class, 'createMessage']);
