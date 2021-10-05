<?php
/** @var App $app */

use App\Controller\AuthController;
use App\Controller\HomeController;
use App\Controller\MessageController;
use App\Controller\SignupController;
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

// login
$app->get('/login', [AuthController::class, 'loginView']);
$app->post('/login', [AuthController::class, 'connectUser']);

// signup
$app->get('/signup', [SignupController::class, 'signupView']);
$app->post('/signup', [SignupController::class, 'signupUser']);

// logout
$app->get('/logout', [AuthController::class, 'logout']);
