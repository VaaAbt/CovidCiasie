<?php

namespace App\Controller;

use App\Model\Message;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Model\User;


class MessageController extends AbstractController
{
    public function messagesView(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $data['users'] = User::getTalkedToUser();
        return $this->render($response, 'messages.html.twig', $data);
    }


}