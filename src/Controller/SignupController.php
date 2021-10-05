<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Model\User;

class SignupController extends AbstractController
{
    public function signupView(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $this->render($response, 'signup.html.twig');
    }    
    public function signupUSer(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $data = $request->getParsedBody(); 
        if($data['password'] == $data["password-c"]){
            User::create($data);
            return $this->render($response, 'login.html.twig');
        }
        return $this->render($response, 'signup.html.twig');
    }
}