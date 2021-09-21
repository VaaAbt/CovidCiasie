<?php
/** @var App $app */

use App\Controller\HomeController;
use Slim\App;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

/**
 * Function that can call a route using controllers
 *
 * @remarks This function is used as a helper to build the controller and call the method
 *
 * @param string $controller - The controller that must be instanciate
 * @param string $method - The method that must be called on the controller
 * @return Closure - The closure for the route call
 */
function callRoute(string $controller, string $method): Closure
{
    return function (Request $request, Response $response) use ($controller, $method) {
        $controller = new $controller();
        return $controller->$method($request, $response);
    };
}

/**
 * ----------------
 * Routes
 * ----------------
 */
$app->get('/', callRoute(HomeController::class, 'index'));
