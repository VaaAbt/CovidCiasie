<?php

namespace App\Utils;

use App\Model\User;

class Auth
{
    /**
     * @var User|null
     */
    private static $_user;

    /**
     * Verify if the user is logged in
     *
     * @return bool
     */
    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['auth']);
    }

    /**
     * Get the current user logged in or null
     *
     * @return User|null - The current user logged in or null if the user is not logged in
     */
    public static function getUser(): ?User
    {
        if (self::$_user) {
            return self::$_user;
        } else if (isset($_SESSION['auth'])) {
            self::$_user = User::query()
                ->where('id', $_SESSION['auth'])
                ->first();
        } else {
            self::$_user = null;
        }

        return self::$_user;
    }

    /**
     * Attempt to log in the user
     *
     * @param string $email - Email of the user
     * @param string $password - Password of the user
     * @return User|null - The user if credentials works or null if not
     */
    public static function attempt(string $email, string $password): ?User
    {
        self::$_user = null;

        // Search the user in the database using its email
        /** @var User|null $user */
        $user = User::query()
            ->where('email', $email)
            ->first();


        // If a user exists with this email, verify the password
        if ($user && password_verify($password, $user->getAttribute('password'))) {
            // Valid credentials, log in the user
            $_SESSION['auth'] = $user->getAttribute('id');
            self::$_user = $user;
        }

        return self::$_user;
    }

    /**
     * Log out the current user
     */
    public static function logout(): void
    {
        unset($_SESSION['auth']);
        self::$_user = null;
    }
}