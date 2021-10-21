<?php

namespace App\Controller;

use App\Model\User;
use App\Utils\Auth;
use App\Utils\FlashMessages;
use App\Utils\Validator;
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

        $dataValidator = [
            'firstname' => Validator::isNotEmpty($request->getParsedBody()['firstname']),
            'lastname' => Validator::isNotEmpty($request->getParsedBody()['lastname']),
            'email' => Validator::isNotEmpty($request->getParsedBody()['email'])
        ];

        $result = (bool)array_product($dataValidator);

        if (!$result) {
            FlashMessages::set('account', 'The submitted data are invalid.');
            return $response->withHeader('Location', '/account')->withStatus(302);
        }

        $userExists = User::query()
            ->where('email', '=', $payload['email'])
            ->where('id', '!=', $user->getAttribute('id'))
            ->exists();

        if ($userExists) {
            FlashMessages::set('account', 'The submitted email is already taken.');
            return $response->withHeader('Location', '/account')->withStatus(302);
        }

        $user->setAttribute('firstname', $payload['firstname']);
        $user->setAttribute('lastname', $payload['lastname']);
        $user->setAttribute('email', $payload['email']);
        $user->setAttribute('contamined', filter_var($payload['contamined'], FILTER_VALIDATE_BOOL));
        $user->save();

        FlashMessages::set('account-success', 'Your account has been updated.');
        return $response->withHeader('Location', '/account')->withStatus(302);
    }

    public function password(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $payload = $request->getParsedBody();
        $user = Auth::getUser();

        $dataValidator = [
            'current-password' => Validator::isNotEmpty($payload['current-password']),
            'new-password' => Validator::isNotEmpty($payload['new-password']),
            'new-password-confirmation' => Validator::isNotEmpty($payload['new-password-confirmation'])
        ];

        $result = (bool)array_product($dataValidator);

        if (!$result) {
            FlashMessages::set('password', 'The submitted data are invalid.');
            return $response->withHeader('Location', '/account');
        } else if ($payload['new-password'] !== $payload['new-password-confirmation']) {
            FlashMessages::set('password', 'The new password confirmation does not match.');
            return $response->withHeader('Location', '/account');
        } else if (!password_verify($payload['current-password'], $user->getAttribute('password'))) {
            FlashMessages::set('password', 'The current password is invalid.');
            return $response->withHeader('Location', '/account');
        }

        $user->setAttribute('password', password_hash($payload['new-password'], PASSWORD_DEFAULT));
        $user->save();

        FlashMessages::set('password-success', 'Your password has been successfully changed.');
        return $response->withHeader('Location', '/account');
    }
}