<?php

namespace App\Controller;

use App\Model\User;
use App\Utils\Auth;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Validator as v;

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

    public function signupUSer(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $data = [
            'firstname' => $request->getParsedBody()['firstname'],
            'lastname' => $request->getParsedBody()['lastname'],
            'email' => $request->getParsedBody()['email'],
            'password' => $request->getParsedBody()['password'],
            'password-confirmation' => $request->getParsedBody()['password-confirmation'],
        ];

        $dataValidator = [
            'firstname' => v::notEmpty()->stringType()->validate($data['firstname']),
            'lastname' => v::notEmpty()->stringType()->validate($data['lastname']),
            'email' => v::notEmpty()->email()->validate($data['email']),
            'password' => v::identical($data['password'])->validate($data['password-confirmation'])
        ];

        $result = (bool)array_product($dataValidator);

        if ($result) {
            User::create($request->getParsedBody());
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