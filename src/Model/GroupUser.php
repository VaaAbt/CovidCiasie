<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model
{
    /**
     * Set the corresponding table name
     *
     * @var string
     */
    protected $table = 'groups_users';

    /**
     * Disable default timestamps columns
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var int
     */
    public $group_id;

    /**
     * @var int
     */
    public $user_id;
}