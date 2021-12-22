<?php

namespace App\Controllers\Admin;

use App\Models\Post;
use App\Models\Comment;
use App\Controllers\Controller;

class CommentController extends Controller
{
    public function list()
    {
        $this->isConnected();
        $comments = (new Comment)->all(true);
        $post = new Post;

        $this->twig->display('admin/comments/list.twig', [
            'page_title' => 'Tous les commentaires',
            'comments' => $comments,
            'post' => $post
        ]);
    }

    public function listNoModerate()
    {
        $this->isConnected();
        $comments = (new Comment)->listModerate(false);
        $post = new Post;

        $this->twig->display('admin/comments/list.twig', [
            'comments' => $comments,
            'page_title' => 'En attente de modération',
            'post' => $post
        ]);
    }

    public function listModerate()
    {
        $this->isConnected();
        $comments = (new Comment)->listModerate();
        $post = new Post;

        $this->twig->display('admin/comments/list.twig', [
            'comments' => $comments,
            'page_title' => 'Commentaires modérés',
            'post' => $post
        ]);
    }

    public function delete(int $id)
    {
        $this->isConnected();

        $comment = (new Comment)->findById($id);
        $result = $comment->delete($id);

        if ($result) {
            return header("Location: /admin/comments");
        }
    }

    public function moderate(int $id)
    {
        $result = (new Comment)->update($id, ['is_moderate' => 1]);

        if ($result) {
            return header('Location: /admin/comments/no-moderate');
        }
    }
}
