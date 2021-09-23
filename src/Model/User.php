<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * Set the corresponding table name
     *
     * @var string
     */
    protected $table = 'users';

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
    public $firstname;

    /**
     * @var string
     */
    public $lastname;

    /**
     * @var int
     */
    public $age;

    /**
     * @var string
     */
    public $phone;

    /**
     * @var string
     */
    public $location;

    /**
     * @var bool
     */
    public $contamined;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;
}