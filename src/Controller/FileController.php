<?php

namespace App\Controller;

use App\Model\File;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class FileController extends AbstractController
{
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
 