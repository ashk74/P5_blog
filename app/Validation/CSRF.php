<?php

namespace App\Validation;

class CSRF
{
    private string $token;

    public function setToken()
    {
        if (!isset($_SESSION['token']) || ($_SESSION['token_time'] + 10) < time()) {
            $this->token = bin2hex(openssl_random_pseudo_bytes(16));
            $_SESSION['token_time'] = time();
        } else {
            $this->token = $_SESSION['token'];
        }
    }

    public function getToken()
    {
        return $this->token;
    }

    public function checkTokens()
    {
        if (isset($_SESSION['token']) && isset($_SESSION['token_time'])) {
            if (($_SESSION['token_time'] + 10) < time()) {
                $this->setToken();
            }
        }
    }
}
