<?php
/** @var App $app */

use App\Controller\AccountController;
use App\Controller\AuthController;
use App\Controller\ContactController;
use App\Controller\GroupController;
use App\Controller\HomeController;
use App\Controller\InvitationController;
use App\Controller\MapController;
use App\Controller\MessageController;
use App\Controller\SearchController;
use App\Controller\FileController;
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
    $group->get('/user/{id}', [MessageController::class, 'getUserMessagesView']);
    $group->post('/user/{id}', [MessageController::class, 'createMessage']);

    $group->get('/group/{id}', [MessageController::class, 'getGroupMessagesView']);
    $group->post('/group/{id}', [MessageController::class, 'createGroupMessage']);
})->add(new AuthMiddleware());

// file
$app->group('/file', function (RouteCollectorProxy $group) {
    $group->get('/download/{id}', [Filecontroller::class, 'download']);
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

    $group->get('/{id}/announcement', [GroupController::class, 'announcementView']);
    $group->post('/{id}/announcement', [GroupController::class, 'announcement']);

    $group->get('/{id}/file', [GroupController::class, 'fileView']);
    $group->post('/{id}/file', [FileController::class, 'uploadFile']);

    $group->post('/{id}/add-member', [GroupController::class, 'addMember']);
})->add(new AuthMiddleware());

// contacts
$app->group('/contacts', function (RouteCollectorProxy $group) {
    $group->get('', [ContactController::class, 'getView']);
    $group->get('/remove/{id}', [ContactController::class, 'remove']);
})->add(new AuthMiddleware());

// invitations
$app->group('/invitation', function (RouteCollectorProxy $group) {
    $group->get('/accept/{id}', [InvitationController::class, 'accept']);
    $group->get('/decline/{id}', [InvitationController::class, 'decline']);
    $group->get('/send/{id}', [InvitationController::class, 'send']);
})->add(new AuthMiddleware());

// search
$app->group('/search', function (RouteCollectorProxy $group) {
    $group->post('', [SearchController::class, 'search']);
})->add(new AuthMiddleware());

//map
$app->get('/map', [MapController::class, 'mapView']);
$app->post('/map', [MapController::class, 'getOtherLocations']);
$app->post('/location', [MapController::class, 'svgLocation']);

// CORS
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});
$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
    throw new HttpNotFoundException($request);
});