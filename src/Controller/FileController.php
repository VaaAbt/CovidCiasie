<?php

namespace App\Controller;

use App\Model\File;
use App\Model\Group;
use App\Model\Message;
use App\Model\GroupUser;
use App\Model\User;
use App\Utils\Auth;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class FileController extends AbstractController
{

    public function uploadFile(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = Auth::getUser()->getAttribute('id');

        $msg = $request->getParsedBody();

        $file = [
            'file_name' => $_FILES['file']['name'],
            'file_type' => $_FILES['file']['type'],
            'file_size' => $_FILES['file']['size'],
            'group_id' => $args['id'],
            'file_content' => file_get_contents($_FILES['file']['tmp_name'])
        ];

        $newFile = File::create($file);
        $message = [
            'receiver_id' => $args['id'],
            'message' => $msg['message'],
            'group_id' => $args['id'],
            'file_id' => $newFile->id
        ];

        Message::create($message);
        return $response->withHeader('Location', '/messages/group/' . $args['id'])->withStatus(302);
    }

    public function download(ServerRequestInterface $request, ResponseInterface $response, array $args){
        
        $id = $args['id'];
        
        $file = File::where('id', '=', $id)->first();

        $size = $file->filesize;
        $type = $file->filetype;
        $name = $file->filename;
        $content = $file->filecontent;

        header("Content-length: $size");
        header("Content-type: $type");
        header("Content-Disposition: attachment; filename=$name");
        echo $content;
        ob_clean();
        flush();
        exit;
    }
}
 