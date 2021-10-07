<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Model\User;
use Respect\Validation\Validator as v;

class SignupController extends AbstractController
{
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
            'password-c' => $request->getParsedBody()['password-c'],
        ];

       $dataValidator = [ 
           'firstname' => v::notEmpty()->stringType()->validate($data['firstname']),
           'lastname' => v::notEmpty()->stringType()->validate($data['lastname']),
           'email' => v::notEmpty()->email()->validate($data['email']),
           'password' => v::identical($data['password'])->validate($data['password-c'])
        ];

        $result = (bool) array_product($dataValidator); 

        if($result){
            User::create($request->getParsedBody());
            return $this->render($response, 'login.html.twig');
        }

        return $this->render($response, 'signup.html.twig');
    }
}