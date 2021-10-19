<?php
/** @var App $app */

use App\Controller\AccountController;
use App\Controller\AuthController;
use App\Controller\GroupController;
use App\Controller\HomeController;
use App\Controller\MapController;
use App\Controller\MessageController;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use Slim\App;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteCollectorProxy;

/**
 * ----------------
 * Routes
 * ----------------
 */
$app->get('/', [HomeController::class, 'index']);

// messages
$app->group('/messages', function (RouteCollectorProxy $group) {
    $group->get('', [MessageController::class, 'messagesView']);
    $group->get('/user/{id}', [MessageController::class, 'getUserMessageView']);
    $group->post('/user/{id}', [MessageController::class, 'createMessage']);

    $group->get('/group/{id}', [MessageController::class, 'getGroupMessageView']);
    $group->post('/group/{id}', [MessageController::class, 'createGroupMessage']);

    $group->post('/search-user', [MessageController::class, 'searchUser']);
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
    $group->post('', [AccountController::class, 'account']);
    $group->post('/password', [AccountController::class, 'password']);
})->add(new AuthMiddleware());

// groups
$app->group('/groups', function (RouteCollectorProxy $group) {
    $group->get('/new', [GroupController::class, 'newView']);
    $group->post('/new', [GroupController::class, 'new']);
})->add(new AuthMiddleware());

//map
$app->get('/map', [MapController::class, 'mapView']);
$app->post('/map', [MapController::class, 'getOtherLocations']);

// CORS
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});
$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
    throw new HttpNotFoundException($request);
});