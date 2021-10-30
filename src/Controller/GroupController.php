<?php

namespace App\Controller;

use App\Model\Announcement;
use App\Model\File;
use App\Model\Group;
use App\Utils\Auth;
use App\Utils\FlashMessages;
use App\Utils\Validator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\UploadedFile;

class GroupController extends AbstractController
{
    public function newView(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $this->render($response, 'groups/new.html.twig');
    }

    public function new(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $payload = $request->getParsedBody();

        $dataValidator = [
            'name' => Validator::isNotEmpty($payload['name'])
        ];

        $result = (bool)array_product($dataValidator);

        if (!$result) {
            FlashMessages::set('group', 'The submitted data are invalid.');
            return $response->withHeader('Location', '/groups/new');
        }

        $group = new Group();
        $group->setAttribute('name', $payload['name']);
        $group->save();

        $group->users()->save(Auth::getUser());


        return $response->withHeader('Location', "/messages/group/{$group->getAttribute('id')}");
    }

    public function announcementView(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $this->render($response, 'groups/announcement.html.twig');
    }

    public function announcement(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $group = Group::query()->where('id', '=', $args['id'])->first();

        $payload = $request->getParsedBody();

        $dataValidator = [
            'message' => Validator::isNotEmpty($payload['message'])
        ];

        $result = (bool)array_product($dataValidator);

        if (!$result) {
            FlashMessages::set('group', 'The submitted data are invalid.');
            return $response->withHeader('Location', "/groups/{$group->getAttribute('id')}/announcement");
        }

        $announcement = [
            'group_id' => $group->getAttribute('id'),
            'message' => $payload['message']
        ];
        Announcement::create($announcement);

        return $response->withHeader('Location', "/messages/group/{$group->getAttribute('id')}");
    }

    public function fileView(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $this->render($response, 'groups/file.html.twig');
    }

    public function file(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $groupId = $args['id'];
        $group = Group::query()->where('id', '=', $groupId)->first();
        if (!$group) {
            FlashMessages::set('messages', 'Group not found.');
            return $response->withHeader('Location', '/messages')->withStatus(404);
        }

        $uploadedFile = $request->getUploadedFiles()['file'] ?? null;

        if (!Validator::isFile($uploadedFile)) {
            FlashMessages::set('file', 'You must provide a valid file.');
            return $response->withHeader('Location', "/group/{$groupId}/file")->withStatus(422);
        }

        /** @var UploadedFile $uploadedFile */

        // Création du dossier de destination si besoin
        $fileDestination = File::getUploadPath() . "/groups/{$groupId}";
        if (!is_dir($fileDestination)) {
            mkdir($fileDestination, 0777, true);
        }

        // Vérifie si le fichier existe déjà
        $fileDestination .= '/' . $uploadedFile->getClientFilename();
        if (file_exists($fileDestination)) {
            FlashMessages::set('file', 'A file with the same name on this group already exists.');
            return $response->withHeader('Location', "/groups/{$groupId}/file")->withStatus(422);
        }

        // Sauvegarde le fichier dans la destination
        $uploadedFile->moveTo($fileDestination);

        // Sauvegarde de la ligne correspondante
        $file = new File();
        $file->setAttribute('group_id', $groupId);
        $file->setAttribute('filename', $uploadedFile->getClientFilename());
        $file->save();

        return $response->withHeader('Location', "/messages/group/{$groupId}");
    }
}