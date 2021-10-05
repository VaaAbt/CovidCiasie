<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Utils\Auth;

class AuthController extends AbstractController
{
    public function loginView(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $this->render($response, 'login.html.twig');
    }

    public function connectUser(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $data = $request->getParsedBody();
        if(Auth::attempt($data['email'], $data['password']))
            return $this->render($response, 'dashboard.html.twig');
        return $this->render($response, 'login.html.twig');
    }

    public function logout(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        Auth::logout();
        return $response->withHeader('Location', '/login')->withStatus(302);
    }
}