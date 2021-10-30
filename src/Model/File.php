<?php

namespace App\Model;

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
}