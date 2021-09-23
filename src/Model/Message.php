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
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $sender_id;

    /**
     * @var int
     */
    public $receiver_id;

    /**
     * @var int
     */
    public $group_id;

    /**
     * @var string
     */
    public $message;
}   