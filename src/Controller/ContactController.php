<?php

namespace App\Controller;

use App\Model\Contact;
use App\Model\GroupUser;
use App\Model\Invitation;
use App\Utils\Auth;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ContactController extends AbstractController
{
    public function getView(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = Auth::getUser()->getAttribute('id');
        $data['contacts'] = Contact::getContacts();
        $data['invitations'] = Invitation::getAllInvitations();
        $data['groups'] = GroupUser::getGroupsOfUser($id);

        return $this->render($response, 'contacts/contacts.html.twig', $data);
    }

    public function remove(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = Auth::getUser()->getAttribute('id');
        Contact::remove($args['id'], $id);
        return $response->withHeader('Location', '/contacts')->withStatus(302);
    }

}