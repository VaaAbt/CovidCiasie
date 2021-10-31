<?php

namespace App\Model;

use App\Utils\Auth;
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

    public static function svgLocationId($data): Location
    {
        $location = new Location();

        $location->setAttribute('latitude', $data['latitude']);
        $location->setAttribute('longitude', $data['longitude']);
        $location->setAttribute('user_id', Auth::getUser()->getAttribute('id'));
        $location->save();

        return $location;
    }
}