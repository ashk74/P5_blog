<?php

namespace App\Controllers;

abstract class Controller
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    protected function view(string $path, ?array $params = null)
    {
        $layout = 'layout.php';

        if ($path == 'blog/index') {
            $layout = 'index.' . $layout;
        }

        ob_start();
        require VIEWS . $path . '.html.php';
        $pageContent = ob_get_clean();
        require VIEWS . $layout;
    }

    protected function isAdmin()
    {
        if (isset($_SESSION['auth']) && $_SESSION['auth'] === 1) {
            return true;
        } else {
            return header('Location: /login');
        }
    }
}
