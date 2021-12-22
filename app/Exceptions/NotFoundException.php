<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class NotFoundException extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function error404() {
        http_response_code(404);
        ob_start();
        require '../views/errors/404.html.php';
        $pageContent = ob_get_clean();
        require '../views/layout.php';
    }
}
