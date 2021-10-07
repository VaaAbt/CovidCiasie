<?php

namespace App\Middleware;

use App\Utils\Auth;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class GuestMiddleware
{
    /**
     * Check if the user is not logged in to continue
     *
     * @param Request $request PSR-7 request
     * @param RequestHandler $handler PSR-15 request handler
     *
     * @return ResponseInterface
     */
    public function __invoke(Request $request, RequestHandler $handler): ResponseInterface
    {
        if (Auth::isLoggedIn()) {
            $response = new Response();

            return $response->withHeader('Location', '/')->withStatus(302);
        }

        return $handler->handle($request);
    }
}