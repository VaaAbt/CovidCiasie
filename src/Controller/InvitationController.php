<?php

namespace App\Controller;

use App\Model\Contact;
use App\Model\GroupUser;
use App\Model\Invitation;
use App\Utils\Auth;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class InvitationController extends AbstractController
{
    public function accept(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $newContact = Contact::create([
            'user1' => Auth::getUser()->getAttribute('id'),
            'user2' => $args['id']
        ]);

        $invitation = Invitation::deleteInvitation([
            'user1' => Auth::getUser()->getAttribute('id'),
            'user2' => $args['id']
        ]);

        return $response->withHeader('Location', '/contacts')->withStatus(302);

    }

    public function decline(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $invitation = Invitation::deleteInvitation([
            'user1' => Auth::getUser()->getAttribute('id'),
            'user2' => $args['id']
        ]);

        return $response->withHeader('Location', '/contacts')->withStatus(302);
    }

    public function send(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $invitation = Invitation::create([
            'user1' => Auth::getUser()->getAttribute('id'),
            'user2' => $args['id']
        ]);

        return $response->withHeader('Location', '/contacts')->withStatus(302);
    }

}