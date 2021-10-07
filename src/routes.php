<?php
/** @var App $app */

use App\Controller\AccountController;
use App\Controller\AuthController;
use App\Controller\HomeController;
use App\Controller\MessageController;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

/**
 * ----------------
 * Routes
 * ----------------
 */
$app->get('/', [HomeController::class, 'index']);

// chat building
$app->group('/chat', function (RouteCollectorProxy $group) {
    $group->get('', [MessageController::class, 'getChat']);
    $group->get('/{user_id}', [MessageController::class, 'getChat']);
    $group->post('/{user_id}', [MessageController::class, 'createMessage']);
})->add(new AuthMiddleware());

// login
$app->group('/login', function (RouteCollectorProxy $group) {
    $group->get('', [AuthController::class, 'loginView']);
    $group->post('', [AuthController::class, 'login']);
})->add(new GuestMiddleware());

// signup
$app->group('/signup', function (RouteCollectorProxy $group) {
    $group->get('', [AuthController::class, 'signupView']);
    $group->post('', [AuthController::class, 'signup']);
})->add(new GuestMiddleware());

// logout
$app->get('/logout', [AuthController::class, 'logout']);

// account
$app->group('/account', function (RouteCollectorProxy $group) {
    $group->get('', [AccountController::class, 'accountView']);
})->add(new AuthMiddleware());