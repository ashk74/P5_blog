<?php

namespace App\Controllers;

use App\Models\User;
use App\Validation\Validator;

class UserController extends Controller
{
    public function login()
    {
        unset($_SESSION['errors']);
        $this->twig->display('auth/login.twig', [
            'form_action' => '/login',
            'signup_link' => '/signup',
            'lost_password' => '/reset'
        ]);
    }

    public function loginPost()
    {
        $validator = new Validator($_POST);
        $errors = $validator->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6', 'max:255']
        ]);

        Validator::flashErrors($errors, '/login');

        $user = (new User)->getbyEmail($_POST['email']);

        if (password_verify($_POST['password'], $user->password)) {
            if ($user->is_admin) {
                $_SESSION['connected'] = (int)$user->is_admin;
                return header('Location: /admin/posts?success=true');
            }
        } else {
            return header('Location: /login');
        }
    }

    public function logout()
    {
        session_destroy();

        return header('Location: /');
    }
}
