<?php

namespace App\Utils;

class Session
{
    public static function unsetSession(string $key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
}
