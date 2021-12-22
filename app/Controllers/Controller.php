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
        if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === 1) {
            return true;
        } else {
            $error = 'Vous n\'avez pas les droits nécessaires pour accéder à ce contenu.';
            $this->twig->display('errors/right.twig', [
                'page_title' => 'Erreur droit administrateur',
                'error' => $error
            ]);
            die();
        }
    }

    protected function isValidate()
    {
        if (isset($_SESSION['is_validate']) && $_SESSION['is_validate'] === 1) {
            return true;
        } else {
            $error = 'Votre compte doit être validé pour accéder à ce contenu.';
            $this->twig->display('errors/right.twig', [
                'page_title' => 'Compte en attente de validation',
                'error' => $error
            ]);
            die();
        }
    }
}
