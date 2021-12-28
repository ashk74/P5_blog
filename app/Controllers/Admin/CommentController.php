<?php

namespace App\Controllers\Admin;

use App\Models\Post;
use App\Models\Comment;
use App\Validation\Validator;
use App\Controllers\Controller;
use App\Utils\Session;

class CommentController extends Controller
{
    /**
     * Display : All comments
     *
     * @return void
     */
    public function list()
    {
        // Check admin right
        $this->isAdmin();

        // Remove session array
        Session::unsetSession('errors');

        // Retrieve all comments
        $comments = (new Comment)->all(true);
        $post = new Post;

        // Send parameters to the layout for display with Twig
        $this->twig->display('admin/comments/list.twig', [
            'page_title' => 'Tous les commentaires',
            'comments' => $comments,
            'post' => $post,
            'token' => $this->token
        ]);
    }

    /**
     * Display : All not moderated comments
     *
     * @return void
     */
    public function listNotModerated ()
    {
        // Check admin right
        $this->isAdmin();

        // Remove session array
        Session::unsetSession('errors');

        // Retrieve all not moderated comments
        $comments = (new Comment)->listModerated(false);
        $post = new Post;

        // Send parameters to the layout for display with Twig
        $this->twig->display('admin/comments/list.twig', [
            'comments' => $comments,
            'page_title' => 'En attente de modération',
            'post' => $post,
            'token' => $this->token
        ]);
    }

    /**
     * Display : All moderated comments
     *
     * @return void
     */
    public function listModerated()
    {
        // Check admin right
        $this->isAdmin();

        // Remove session array
        Session::unsetSession('errors');

        // Retrieve all moderated comments
        $comments = (new Comment)->listModerated();
        $post = new Post;

        // Send parameters to the layout for display with Twig
        $this->twig->display('admin/comments/list.twig', [
            'comments' => $comments,
            'page_title' => 'Commentaires modérés',
            'post' => $post,
            'token' => $this->token
        ]);
    }

    /**
     * Validate form : Delete comment
     *
     * @param integer $id ID of the comment to delete
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

        // Check errors and delete
        if (!$errors) {
            $result = (new Comment)->delete($id);

            if ($result) {
                return header("Location: /admin/comments");
            }
        } else {
            $validator->flashErrors($errors, '/admin/comments');
        }
    }

    /**
     * Validate form : Moderate comment
     *
     * @param integer $id ID of the comment to moderate
     *
     * @return void
     */
    public function moderate(int $id)
    {
        // Check admin right
        $this->isAdmin();

        // Send token to the validator
        $validator = new Validator($_POST);
        $errors = $validator->validate([
            'token' => ['required', 'token']
        ]);

        // Check errors and moderate
        if (!$errors) {
            $result = (new Comment)->update($id, ['is_moderate' => 1]);

            if ($result) {
                return header('Location: /admin/comments/not-moderated');
            }
        } else {
            $validator->flashErrors($errors, '/admin/comments/not-moderated');
        }
    }
}
