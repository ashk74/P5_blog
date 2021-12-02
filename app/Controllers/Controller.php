<?php

namespace App\Controllers;

abstract class Controller
{
    public function view(string $path, ?array $params = null)
    {
        ob_start();
        $path = str_replace('.', DIRECTORY_SEPARATOR, $path);
        require VIEWS . $path . '.html.php';
        $pageContent = ob_get_clean();
        require VIEWS . 'layout.php';
    }
}