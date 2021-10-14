<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /**
     * Set the corresponding table name
     *
     * @var string
     */
    protected $table = 'locations';

    /**
     * Disable default timestamps columns
     *
     * @var bool
     */
    public $timestamps = false;


    public static function getLocationId($id)
    {
        $location = Location::where('user_id', $id)->first();

        return $location;
    }
}