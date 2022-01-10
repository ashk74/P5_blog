<?php

namespace App\Utils;

use App\Models\User;

class Session
{
    public static function setSession(User $user): void
    {
        $_SESSION['success'] = true;
        $_SESSION['connected'] = true;
        $_SESSION['user_id'] = (int) $user->id;
        $_SESSION['is_admin'] = (int) $user->is_admin;
        $_SESSION['is_validate'] = (int) $user->is_validate;
        $_SESSION['fullname'] = (string) $user->first_name . ' ' . $user->last_name;
        $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['last_access'] = time();
    }

    public static function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(['cookie_secure' => false, 'cookie_httponly' => true]);
        }
    }

    public static function unsetSession(string $key): void
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public static function logout()
    {
        session_unset();
        session_destroy();

        return header('Location: /');
    }

    public static function securedHijacking()
    {
        if (isset($_SESSION['connected']) && $_SESSION['connected']) {
            if (!isset($_SESSION['ip_address']) || !isset($_SESSION['last_access'])) {
                self::logout();
            }

            if ($_SERVER['REMOTE_ADDR'] != $_SESSION['ip_address']) {
                self::logout();
            }

            if ($_SESSION['last_access'] + 3600 < time()) {
                self::logout();
            } else {
                $_SESSION['last_access'] = time();
            }
        }
    }
}
