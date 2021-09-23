<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{

    /**
     * Set the corresponding table name
     *
     * @var string
     */
    protected $table = 'contacts';

    /**
     * Disable default timestamps columns
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var int
     */
    public $user1_id;

    /**
     * @var int
     */
    public $user2_id;

}