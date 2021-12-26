<?php

namespace App\Controllers\Admin;

use App\Models\Post;
use App\Models\Comment;
use App\Validation\Validator;
use App\Controllers\Controller;

class CommentController extends Controller
{
    public function list()
    {
        $this->isAdmin();

        unset($_SESSION['errors']);
        $comments = (new Comment)->all(true);
        $post = new Post;

        $this->twig->display('admin/comments/list.twig', [
            'page_title' => 'Tous les commentaires',
            'comments' => $comments,
            'post' => $post,
            'token' => $this->token
        ]);
    }

    public function listNoModerate()
    {
        $this->isAdmin();

        unset($_SESSION['errors']);
        $comments = (new Comment)->listModerate(false);
        $post = new Post;

        $this->twig->display('admin/comments/list.twig', [
            'comments' => $comments,
            'page_title' => 'En attente de modération',
            'post' => $post,
            'token' => $this->token
        ]);
    }

    public function listModerate()
    {
        $this->isAdmin();

        unset($_SESSION['errors']);
        $comments = (new Comment)->listModerate();
        $post = new Post;

        $this->twig->display('admin/comments/list.twig', [
            'comments' => $comments,
            'page_title' => 'Commentaires modérés',
            'post' => $post,
            'token' => $this->token
        ]);
    }

    public function delete(int $id)
    {
        $this->isAdmin();

        $validator = new Validator($_POST);

        $errors = $validator->validate([
            'token' => ['required', 'token']
        ]);

        if (!$errors) {
            $comment = (new Comment)->findById($id);
            $result = $comment->delete($id);

            if ($result) {
                return header("Location: /admin/comments");
            }
        } else {
            $validator->flashErrors($errors, '/admin/comments');
        }
    }

    public function moderate(int $id)
    {
        $this->isAdmin();

        $validator = new Validator($_POST);

        $errors = $validator->validate([
            'token' => ['required', 'token']
        ]);

        if (!$errors) {
            $result = (new Comment)->update($id, ['is_moderate' => 1]);

            if ($result) {
                return header('Location: /admin/comments/no-moderate');
            }
        } else {
            $validator->flashErrors($errors, '/admin/comments/no-moderate');
        }
    }
}
