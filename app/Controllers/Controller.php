<?php

namespace App\Controllers;

abstract class Controller
{
    protected $twig = null;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->loadTwig();
        $this->twig->display = 'echo $this->twig->render';
    }

    protected function loadTwig(): object
    {
        $loader = new \Twig\Loader\FilesystemLoader(['../templates', '../templates/views', '../templates/macros']);
        $this->twig = new \Twig\Environment($loader, [
            'debug' => true,
            'cache' => false,
            'autoescape' => 'html'
        ]);
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
        $this->twig->addGlobal('_get', $_GET);
        $this->twig->addGlobal('_session', $_SESSION);
        return $this->twig;
    }

    protected function isConnected()
    {
        if (isset($_SESSION['connected']) && $_SESSION['connected'] === 1) {
            return true;
        } else {
            return header('Location: /login');
        }
    }

    protected function isAdmin()
    {
        return (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === 1) ? true : false;
    }

    protected function isValidate()
    {
        return (isset($_SESSION['isValidate']) && $_SESSION['isValidate'] === 1) ? true : false;
    }
}
