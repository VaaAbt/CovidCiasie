<?php

namespace App\Controller;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

class HomeController extends AbstractController
{
    public function index(Request $request, Response $response): Response
    {
        $response->getBody()->write('Hello from controller');
        return $response;
    }
}