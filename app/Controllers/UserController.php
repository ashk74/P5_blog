<?php

namespace App\Controllers;

use App\Models\User;
use App\Utils\Session;
use App\Validation\Validator;

class UserController extends Controller
{
    private array $userInfos = [];

    /**
     * Display form : Signup for create new user account
     *
     * @return void
     */
    public function signup()
    {
        // Remove session array
        Session::unsetSession('errors');
        Session::unsetSession('success');

        // Check if user is not connected and send parameters to the layout for display with Twig
        if (!$this->isConnected()) {
            $this->twig->display('auth/signup.twig', [
                'form_action' => '/signup',
                'login_link' => '/login',
                'lost_password' => '/reset',
                'token' => $this->token
            ]);
        } else {
            // Redirect to the homepage
            header('Location: /');
        }
    }

    /**
     * Validate form : Create new user account
     *
     * @return void
     */
    public function signupPost()
    {
        // Send user data to the validator
        $validator = new Validator($_POST);
        $errors = $validator->validate([
            'first_name' => ['required', 'min:2', 'max:70'],
            'last_name' => ['required', 'min:2', 'max:70'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6', 'max:255'],
            'check_password' => ['required', 'min:6', 'max:255'],
            'token' => ['required', 'token']
        ]);

        // Retrieve cleaned data
        $cleanedData = $validator->getSanitizedData();

        // Check is email is already used
        $userExist = (new User)->isEmailExist($cleanedData['email']);

        // Check data and insert a new user in the table
        if (!$userExist) {
            $this->userInfos = array_slice($cleanedData, -6, 3);
            $passwords = array_slice($cleanedData, -3, 2);

            if ($passwords['password'] === $passwords['checkPassword']) {
                $this->userInfos['password'] = password_hash($passwords['password'], PASSWORD_BCRYPT, ['cost' => 9]);
                $user = (new User)->create($this->userInfos);
                $_SESSION['success'] = true;
                return header('Location: /signup');
            } else {
                $errors['password'][] = 'Les mots de passe doivent être identiques';
            }
        } else {
            $errors['email'][] = 'Un compte utilise déjà cette adresse email';
        }

        // Store error in $_SESSION['errors]
        $validator->flashErrors($errors, '/signup');
    }

    /**
     * Display form : Login
     *
     * @return void
     */
    public function login()
    {
        // Remove session array
        Session::unsetSession('errors');
        Session::unsetSession('success');

        // Check if user is not connected and send parameters to the layout for display with Twig
        if (!$this->isConnected()) {
            $this->twig->display('auth/login.twig', [
                'form_action' => '/login',
                'signup_link' => '/signup',
                'lost_password' => '/reset',
                'token' => $this->token
            ]);
        } else {
            header('Location: /');
        }
    }

    /**
     * Validate form : Check user data and connect
     *
     * @return void
     */
    public function loginPost()
    {
        // Send user data to the validator
        $validator = new Validator($_POST);
        $errors = $validator->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6', 'max:255'],
            'token' => ['required', 'token']
        ]);

        // Retrieve cleaned data
        $this->userInfos = $validator->getSanitizedData();

        $user = new User;

        // Check if user exist with email
        if (!$user->isEmailExist($this->userInfos['email'])) {
            $errors['password'][] = 'Aucun compte existant avec cette adresse email';
        }

        $user = $user->findByEmail($this->userInfos['email']);

        // Check password and store data in session
        if (password_verify($this->userInfos['password'], $user->password)) {
            $_SESSION['success'] = true;
            $_SESSION['connected'] = true;
            $_SESSION['user_id'] = (int) $user->id;
            $_SESSION['is_admin'] = (int) $user->is_admin;
            $_SESSION['is_validate'] = (int) $user->is_validate;
            $_SESSION['fullname'] = (string) $user->first_name . ' ' . $user->last_name;

            ($user->is_validate) ? header('Location: /admin/posts') : header('Location: /');
        } else {
            $errors['password'][] = 'Mauvais mot de passe';
        }

        // Store error in $_SESSION['errors]
        $validator->flashErrors($errors, '/login');
    }

    /**
     * Destroy session and redirect
     *
     * @return void
     */
    public function logout()
    {
        session_destroy();

        return header('Location: /');
    }
}
