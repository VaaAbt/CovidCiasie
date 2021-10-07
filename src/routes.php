<?php
/** @var App $app */

use App\Controller\AccountController;
use App\Controller\AuthController;
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

// login
$app->get('/login', [AuthController::class, 'loginView']);
$app->post('/login', [AuthController::class, 'login']);

// signup
$app->get('/signup', [AuthController::class, 'signupView']);
$app->post('/signup', [AuthController::class, 'signup']);

// logout
$app->get('/logout', [AuthController::class, 'logout']);

// account
$app->get('/account', [AccountController::class, 'accountView']);