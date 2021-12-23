<?php

namespace App\Validation;

class CSRF
{
    private static string $token;

    private static function setToken()
    {
        if (!isset($_SESSION['token']) || ($_SESSION['token_time'] + 600) < time()) {
            self::$token = bin2hex(openssl_random_pseudo_bytes(16));
            $_SESSION['token'] = self::$token;
            $_SESSION['token_time'] = time();
        } else {
            self::$token = $_SESSION['token'];
        }
    }

    public static function getToken()
    {
        self::setToken();
        return self::$token;
    }

    public static function checkTokens(string $token)
    {
        if (!isset($_SESSION['token']) && !isset($_SESSION['token_time'])) {
            return false;
        }

        if ($_SESSION['token'] !== $token) {
            return false;
        }
        return true;
    }
}
