<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Model\Message;
use App\Utils\Auth;
use App\Model\User;

class MessageController extends AbstractController
{
    public function getChat(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        // $data['chats'] = Message::getUserChats(Auth::getUser());
        $data['users'] = User::getTalkedToUser();
        return $this->render($response, 'chat.html.twig', $data);
    }

    public function createMessage(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        Message::create($request->getParsedBody());
        header("Refresh:0");
    }
}