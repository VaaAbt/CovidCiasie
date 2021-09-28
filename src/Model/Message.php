<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * Set the corresponding table name
     *
     * @var string
     */
    protected $table = 'messages';

    /**
     * Disable default timestamps columns
     *
     * @var bool
     */
    public $timestamps = false;
}   