<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function list()
    {
        $this->isConnected();
        $this->isAdmin();

        $users = (new User)->all();

        $this->twig->display('admin/users/list.twig', [
            'users' => $users,
            'page_title' => 'Gestion des utilisateurs',
            'page_subtitle' => 'Tous les utilisateurs'
        ]);
    }

    public function listNoValidate()
    {
        $this->isConnected();
        $this->isAdmin();

        $users = (new User)->listValidate(false);

        $this->twig->display('admin/users/list.twig', [
            'users' => $users,
            'page_title' => 'Gestion des utilisateurs',
            'page_subtitle' => 'Utilisateurs non validés'
        ]);
    }

    public function listValidate()
    {
        $this->isConnected();
        $this->isAdmin();

        $users = (new User)->listValidate();

        $this->twig->display('admin/users/list.twig', [
            'users' => $users,
            'page_title' => 'Gestion des utilisateurs',
            'page_subtitle' => 'Utilisateurs validés'
        ]);
    }

    public function listAdmin()
    {
        $this->isConnected();
        $this->isAdmin();

        $users = (new User)->listAdmin();

        $this->twig->display('admin/users/list.twig', [
            'users' => $users,
            'page_title' => 'Gestion des utilisateurs',
            'page_subtitle' => 'Liste des administrateurs'
        ]);
    }

    public function delete(int $id)
    {
        $this->isConnected();
        $this->isAdmin();

        $user = (new User);
        $result = $user->delete($id);

        if ($result) {
            return header('Location: /admin/users');
        }
    }

    public function updateAdminRole(int $id)
    {
        $this->isConnected();
        $this->isAdmin();

        $user = new User;
        $isAdmin = $user->findById($id)->is_admin;
        $result = $user->update($id, ['is_admin' => !$isAdmin]);

        if ($result) {
            return header('Location: /admin/users');
        }
    }

    public function validateUser(int $id)
    {
        $this->isConnected();
        $this->isAdmin();

        $user = new User;
        $result = $user->update($id, ['is_validate' => 1]);

        if ($result) {
            return header('Location: /admin/users');
        }
    }
}
