<?php

namespace App\Controllers\Admin;

use App\Models\User;
use App\Utils\Session;
use App\Validation\Validator;
use App\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display : All users
     *
     * @return void
     */
    public function list(): void
    {
        // Check admin right
        $this->isAdmin();

        // Remove session array
        Session::unsetSession('errors');
        Session::unsetSession('success');

        // Retrieve all users
        $users = (new User)->all();

        // Send parameters to the layout for display with Twig
        $this->twig->display('admin/users/list.twig', [
            'users' => $users,
            'page_title' => 'Gestion des utilisateurs',
            'page_subtitle' => 'Tous les utilisateurs',
            'token' => $this->token
        ]);
    }

    /**
     * Display : All not validated users
     *
     * @return void
     */
    public function listNotValidated(): void
    {
        // Check admin right
        $this->isAdmin();

        // Remove session array
        Session::unsetSession('errors');
        Session::unsetSession('success');

        // Retrieve all not validated users
        $users = (new User)->listValidated(false);

        // Send parameters to the layout for display with Twig
        $this->twig->display('admin/users/list.twig', [
            'users' => $users,
            'page_title' => 'Gestion des utilisateurs',
            'page_subtitle' => 'Utilisateurs non validés',
            'token' => $this->token
        ]);
    }

    /**
     * Display : All validated users
     *
     * @return void
     */
    public function listValidated(): void
    {
        // Check admin right
        $this->isAdmin();

        // Remove session array
        Session::unsetSession('errors');
        Session::unsetSession('success');

        // Retrieve all validated users
        $users = (new User)->listValidated();

        // Send parameters to the layout for display with Twig
        $this->twig->display('admin/users/list.twig', [
            'users' => $users,
            'page_title' => 'Gestion des utilisateurs',
            'page_subtitle' => 'Utilisateurs validés',
            'token' => $this->token
        ]);
    }

    /**
     * Display : All admin users
     *
     * @return void
     */
    public function listAdmin()
    {
        // Check admin right
        $this->isAdmin();

        // Remove session array
        Session::unsetSession('errors');
        Session::unsetSession('success');

        // Retrieve all admin users
        $users = (new User)->listAdmin();

        // Send parameters to the layout for display with Twig
        $this->twig->display('admin/users/list.twig', [
            'users' => $users,
            'page_title' => 'Gestion des utilisateurs',
            'page_subtitle' => 'Liste des administrateurs',
            'token' => $this->token
        ]);
    }

    /**
     * Validate form : Delete user
     *
     * @param integer $id ID of the user to delete
     *
     * @return void
     */
    public function delete(int $id)
    {
        // Check admin right
        $this->isAdmin();

        // Send token to the validator
        $validator = new Validator($_POST);
        $errors = $validator->validate([
            'token' => ['required', 'token']
        ]);

        // Check errors and delete user
        if (!$errors) {
            $result = (new User)->delete($id);

            if ($result) {
                return header('Location: /admin/users');
            }
        } else {
            $validator->flashErrors($errors, '/admin/users');
        }
    }

    /**
     * Validate form : Update admin role
     *
     * @param integer $id ID of the user to update admin role
     *
     * @return void
     */
    public function updateAdminRole(int $id)
    {
        // Check admin right
        $this->isAdmin();

        // Send token to the validator
        $validator = new Validator($_POST);
        $errors = $validator->validate([
            'token' => ['required', 'token']
        ]);

        // Check errors and update admin role
        if (!$errors) {
            $user = new User;
            $isAdmin = $user->findById($id)->is_admin;
            $result = $user->update($id, ['is_admin' => !$isAdmin]);

            if ($result) {
                return header('Location: /admin/users');
            }
        } else {
            $validator->flashErrors($errors, '/admin/users');
        }
    }

    /**
     * Validate form : Update validate user
     *
     * @param integer $id ID of the user to validate
     *
     * @return void
     */
    public function validateUser(int $id)
    {
        // Check admin right
        $this->isAdmin();

        // Send token to the validator
        $validator = new Validator($_POST);
        $errors = $validator->validate([
            'token' => ['required', 'token']
        ]);

        // Check errors and update validate status
        if (!$errors) {
            $user = new User;
            $result = $user->update($id, ['is_validate' => 1]);

            if ($result) {
                return header('Location: /admin/users');
            }
        } else {
            $validator->flashErrors($errors, '/admin/users');
        }
    }
}
