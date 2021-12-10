<?php

namespace App\Controllers;

use App\Models\User;
use App\Validation\Validator;

class UserController extends Controller
{
    public function login()
    {
        return $this->view('auth/login');
    }

    public function loginPost()
    {
        $validator = new Validator($_POST);
        $errors = $validator->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6', 'max:255']
        ]);

        Validator::saveErrors($errors);

        $user = (new User)->getbyEmail($_POST['email']);

        if (password_verify($_POST['password'], $user->password)) {
            if ($user->is_admin) {
                $_SESSION['auth'] = (int)$user->is_admin;
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
