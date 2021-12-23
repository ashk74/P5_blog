<?php

namespace App\Controllers;

use App\Models\User;
use App\Validation\CSRF;
use App\Validation\Validator;

class UserController extends Controller
{
    private array $userInfos = [];

    public function signup()
    {
        unset($_SESSION['errors']);

        $this->twig->display('auth/signup.twig', [
            'form_action' => '/signup',
            'login_link' => '/login',
            'lost_password' => '/reset',
            'token' => $this->token
        ]);
    }

    public function signupPost()
    {
        $validator = new Validator($_POST);
        $errors = $validator->validate([
            'first_name' => ['required', 'min:2', 'max:70'],
            'last_name' => ['required', 'min:2', 'max:70'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6', 'max:255'],
            'checkPassword' => ['required', 'min:6', 'max:255'],
            'token' => ['required', 'token']
        ]);

        $cleanedData = $validator->getData();

        $userExist = (new User)->emailExist($cleanedData['email']);

        if (!$userExist) {
            $this->userInfos = array_slice($cleanedData, -6, 3);
            $passwords = array_slice($cleanedData, -3, 2);

            if ($passwords['password'] === $passwords['checkPassword']) {
                $this->userInfos['password'] = password_hash($passwords['password'], PASSWORD_BCRYPT, ['cost' => 9]);
                $user = (new User)->create($this->userInfos);
                return header('Location: /signup?success=true');
            } else {
                $errors['password'][] = 'Les mots de passe doivent être identiques';
            }
        } else {
            $errors['email'][] = 'Un compte utilise déjà cette adresse email';
        }

        $validator->flashErrors($errors, '/signup');
    }

    public function login()
    {
        unset($_SESSION['errors']);

        $this->twig->display('auth/login.twig', [
            'form_action' => '/login',
            'signup_link' => '/signup',
            'lost_password' => '/reset',
            'token' => $this->token
        ]);
    }

    public function loginPost()
    {
        $validator = new Validator($_POST);

        $errors = $validator->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6', 'max:255'],
            'token' => ['required', 'token']
        ]);

        $cleanedData = $validator->getData();

        $user = new User;

        if (!$user->emailExist($cleanedData['email'])) {
            $errors['password'][] = 'Aucun compte existant avec cette adresse email';
        }

        $user = $user->getbyEmail($cleanedData['email']);

        if (password_verify($cleanedData['password'], $user->password)) {
            $_SESSION['connected'] = 1;
            $_SESSION['user_id'] = (int) $user->id;
            $_SESSION['is_admin'] = (int) $user->is_admin;
            $_SESSION['is_validate'] = (int) $user->is_validate;
            $_SESSION['fullname'] = (string) $user->first_name . ' ' . $user->last_name;

            ($user->is_validate) ? header('Location: /admin/posts?success=true') : header('Location: /');
        } else {
            $errors['password'][] = 'Mauvais mot de passe';
        }

        $validator->flashErrors($errors, '/login');
    }

    public function logout()
    {
        session_destroy();

        return header('Location: /');
    }
}
