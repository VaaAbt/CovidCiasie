<?php

namespace App\Controller;

use App\Model\User;
use App\Utils\Auth;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AuthController extends AbstractController
{
    public function loginView(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $this->render($response, 'login.html.twig');
    }

    public function login(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $data = $request->getParsedBody();

        if (Auth::attempt($data['email'], $data['password'])) { // login success
            return $response->withHeader('Location', '/')->withStatus(302);
        }

        return $response->withHeader('Location', '/login')->withStatus(302);
    }

    public function signupView(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $this->render($response, 'signup.html.twig');
    }

    public function signup(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $data = $request->getParsedBody();
        
        if ($data['password'] == $data["password-confirmation"]) {
            User::create($data);
            return $this->render($response, 'login.html.twig');
        }

        return $this->render($response, 'signup.html.twig');
    }

    public function logout(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        Auth::logout();
        return $response->withHeader('Location', '/login')->withStatus(302);
    }
}