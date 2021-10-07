<?php

namespace App\Controller;

use App\Utils\Auth;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AccountController extends AbstractController
{
    public function accountView(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $this->render($response, 'account.html.twig');
    }

    public function account(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $payload = $request->getParsedBody();
        $user = Auth::getUser();

        // TODO: Basic validation with the validator

        $user->setAttribute('firstname', $payload['firstname']);
        $user->setAttribute('lastname', $payload['lastname']);
        $user->setAttribute('email', $payload['email']);
        $user->setAttribute('contamined', filter_var($payload['contamined'], FILTER_VALIDATE_BOOL));
        $user->save();

        return $response->withHeader('Location', '/account');
    }

    public function password(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $payload = $request->getParsedBody();
        $user = Auth::getUser();

        // TODO: Basic validation with the validator

        // Change the password if the current password is correct
        if (password_verify($payload['current-password'], $user->getAttribute('password'))) {
            $user->setAttribute('password', password_hash($payload['new-password'], PASSWORD_DEFAULT));
            $user->save();
        }

        return $response->withHeader('Location', '/account');
    }
}