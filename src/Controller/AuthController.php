<?php

namespace App\Controller;

use App\Model\User;
use App\Utils\Auth;
use App\Utils\FlashMessages;
use App\Utils\Validator;
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

        FlashMessages::set('credentials', 'The credentials are invalid.');
        return $response->withHeader('Location', '/login')->withStatus(302);
    }

    public function signupView(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $this->render($response, 'signup.html.twig');
    }

    public function signup(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $payload = $request->getParsedBody();

        $dataValidator = [
            'firstname' => Validator::isNotEmpty($payload['firstname']),
            'lastname' => Validator::isNotEmpty($payload['lastname']),
            'email' => Validator::isEmail($payload['email']),
            'password' => Validator::isEqual($payload['password'], $payload['password-confirmation']),
            'email_unique' => !Validator::isEmailAlreadyExist($payload['email'])
        ];

        $result = (bool)array_product($dataValidator);

        if ($result) {
            User::create($payload);
            Auth::attempt($payload['email'], $payload['password']);

            return $response->withHeader('Location', '/')->withStatus(302);
        }

        if (!$dataValidator['email_unique']) {
            FlashMessages::set('signup', 'The email is already taken.');
        } else {
            FlashMessages::set('signup', 'The form contains invalid data.');
        }

        return $response->withHeader('Location', '/signup')->withStatus(422);
    }

    public function logout(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        Auth::logout();
        return $response->withHeader('Location', '/login')->withStatus(302);
    }
}