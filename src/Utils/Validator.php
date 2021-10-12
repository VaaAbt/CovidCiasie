<?php

namespace App\Utils;

use App\Model\User;

class Validator
{

    /**
     * Check if variable isn't empty
     */
    public static function isNotEmpty($var): bool
    {
        return $var != NULL;
    }

    /**
     * Check if variable is an email type
     */
    public static function isEmail($var): bool
    {
        return (bool)filter_var($var, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Check if two variables are equals
     */
    public static function isEqual($var, $valid): bool
    {
        return $var == $valid;
    }

    /**
     * Check if the user doesn't exist
     */
    public static function isEmailAlreadyExist($var): bool
    {
        return User::query()->where('email', $var)->exists();
    }
}