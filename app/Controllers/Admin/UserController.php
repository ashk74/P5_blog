<?php

namespace App\Controllers\Admin;

use App\Models\User;
use App\Validation\Validator;
use App\Controllers\Controller;

class UserController extends Controller
{
    public function list()
    {
        $this->isConnected();
        $this->isAdmin();

        unset($_SESSION['errors']);
        $users = (new User)->all();

        $this->twig->display('admin/users/list.twig', [
            'users' => $users,
            'page_title' => 'Gestion des utilisateurs',
            'page_subtitle' => 'Tous les utilisateurs',
            'token' => $this->token
        ]);
    }

    public function listNoValidate()
    {
        $this->isConnected();
        $this->isAdmin();

        unset($_SESSION['errors']);
        $users = (new User)->listValidate(false);

        $this->twig->display('admin/users/list.twig', [
            'users' => $users,
            'page_title' => 'Gestion des utilisateurs',
            'page_subtitle' => 'Utilisateurs non validés',
            'token' => $this->token
        ]);
    }

    public function listValidate()
    {
        $this->isConnected();
        $this->isAdmin();

        unset($_SESSION['errors']);
        $users = (new User)->listValidate();

        $this->twig->display('admin/users/list.twig', [
            'users' => $users,
            'page_title' => 'Gestion des utilisateurs',
            'page_subtitle' => 'Utilisateurs validés',
            'token' => $this->token
        ]);
    }

    public function listAdmin()
    {
        $this->isConnected();
        $this->isAdmin();

        unset($_SESSION['errors']);
        $users = (new User)->listAdmin();

        $this->twig->display('admin/users/list.twig', [
            'users' => $users,
            'page_title' => 'Gestion des utilisateurs',
            'page_subtitle' => 'Liste des administrateurs',
            'token' => $this->token
        ]);
    }

    public function delete(int $id)
    {
        $this->isConnected();
        $this->isAdmin();

        $validator = new Validator($_POST);

        $errors = $validator->validate([
            'token' => ['required', 'token']
        ]);

        if (!$errors) {
            $user = (new User);
            $result = $user->delete($id);

            if ($result) {
                return header('Location: /admin/users');
            }
        } else {
            $validator->flashErrors($errors, '/admin/users');
        }
    }

    public function updateAdminRole(int $id)
    {
        $this->isConnected();
        $this->isAdmin();

        $validator = new Validator($_POST);

        $errors = $validator->validate([
            'token' => ['required', 'token']
        ]);

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

    public function validateUser(int $id)
    {
        $this->isConnected();
        $this->isAdmin();

        $validator = new Validator($_POST);

        $errors = $validator->validate([
            'token' => ['required', 'token']
        ]);

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
