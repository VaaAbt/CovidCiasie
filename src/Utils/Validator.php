<?php

namespace App\Utils;

use App\Model\User;
use Slim\Psr7\UploadedFile;

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

    /**
     * Check if the var is a file
     *
     * @param $var
     * @return bool
     */
    public static function isFile($var): bool
    {
        return $var instanceof UploadedFile;
    }
}