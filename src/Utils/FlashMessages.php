<?php

namespace App\Utils;

class FlashMessages
{
    /**
     * Init the flash session array
     */
    private static function init(): void
    {
        if (!isset($_SESSION['flash'])) {
            $_SESSION['flash'] = [];
        }
    }

    /**
     * Set a flash message
     *
     * @param string $key - Key of the flash message
     * @param string $message - The flash message
     */
    public static function set(string $key, string $message): void
    {
        self::init();
        $_SESSION['flash'][$key] = $message;
    }

    /**
     * Check if the flash messages contains the key
     *
     * @param string $key - Key of the flash message
     * @return bool - If the flash messages contains the key or not
     */
    public static function has(string $key): bool
    {
        self::init();
        return isset($_SESSION['flash'][$key]);
    }

    /**
     * Get the flash message and removes it if exists
     *
     * @param string $key - Key of the flash message
     * @return string|null - Flash message if exists or null
     */
    public static function retrieve(string $key): ?string
    {
        $message = null;
        if (self::has($key)) {
            $message = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
        }

        return $message;
    }
}