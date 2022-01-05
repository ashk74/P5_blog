<?php

namespace App\Exceptions;

use App\Controllers\Controller;
use Exception;
use Throwable;

class NotFoundException extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function error404()
    {
        // Send http response 404
        http_response_code(404);
        $controller = new Controller;

        // Send parameters to the layout for display with Twig
        $controller->twig->display('errors/404.twig', [
            'page_title' => 'Erreur 404 - Page introuvable'
        ]);
    }
}
