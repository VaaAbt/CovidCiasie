<?php

namespace App\Model;

use App\Utils\Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /**
     * Set the corresponding table name
     *
     * @var string
     */
    protected $table = 'files';

    /**
     * Disable default timestamps columns
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the upload path
     *
     * @return string
     */
    public static function getUploadPath(): string
    {
        return $_SERVER['DOCUMENT_ROOT'] . '/uploads';
    }

    /**
     * add a file to the database
     *
     * @return string
     */
    public static function create(array $data): File
    {
        $file = new File();

        $file->setAttribute('filename', $data['file_name']);
        $file->setAttribute('filetype', $data['file_type']);
        $file->setAttribute('filesize', $data['file_size']);
        $file->setAttribute('filecontent', $data['file_content']);
        $file->setAttribute('group_id', $data['group_id']);
        $file->save();

        return $file;
    }
}