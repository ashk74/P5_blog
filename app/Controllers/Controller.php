<?php

namespace App\Controllers;

abstract class Controller
{
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
}