<?php

namespace App\Controllers;

use App\Utils\Session;
use App\Validation\CSRF;

class Controller
{
    public $twig = null;
    protected string $token;

    /**
     * Check session status and start if necessary. Secure hijacking. Generate and store token. Load twig.
     */
    public function __construct()
    {
        Session::startSession();
        Session::securedHijacking();

        $this->token = CSRF::getToken();
        $this->loadTwig();
        $this->twig->display = 'echo $this->twig->render';
    }

    /**
     * Configure and return Twig
     *
     * @return object
     */
    protected function loadTwig(): object
    {
        $loader = new \Twig\Loader\FilesystemLoader(['../templates', '../templates/views', '../templates/macros']);
        $this->twig = new \Twig\Environment($loader, [
            'debug' => false,
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
        if (isset($_SESSION['connected']) && $_SESSION['connected']) {
            return true;
        } else {
            return false;
        }
    }

    protected function isAdmin()
    {
        if ($this->isConnected()) {
            if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === 1) {
                return true;
            } else {
                $this->twig->display('errors/right.twig', [
                    'page_title' => 'Erreur droit administrateur',
                    'error' => 'Vous n\'avez pas les droits nécessaires pour accéder à ce contenu.'
                ]);
                return false;
            }
        } else {
            header('Location: /login');
        }
    }

    protected function isValidated()
    {
        if ($this->isConnected()) {
            if (isset($_SESSION['is_validate']) && $_SESSION['is_validate'] === 1) {
                return true;
            } else {
                $this->twig->display('errors/right.twig', [
                    'page_title' => 'Compte en attente de validation',
                    'error' => 'Votre compte doit être validé pour accéder à ce contenu.'
                ]);
                return false;
            }
        } else {
            header('Location: /login');
        }
    }
}
