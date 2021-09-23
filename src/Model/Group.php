<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /**
     * Set the corresponding table name
     *
     * @var string
     */
    protected $table = 'groups';

    /**
     * Disable default timestamps columns
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;
}