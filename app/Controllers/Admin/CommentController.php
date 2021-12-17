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
        $this->isConnected();
        if ($this->isValidate()) {
            $comment = new Comment;
            $comments = $comment->all(true);
            $post = new Post;

            $this->twig->display('admin/comments/list.twig', [
                'page_title' => 'Modération des commentaires',
                'comments' => $comments,
                'post' => $post
            ]);
        }
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
        $result = (new Comment)->update($id, ['is_moderate' => 1, 'moderator' => $_SESSION['fullname']]);

        if ($result) {
            return header('Location: /admin/comments');
        }
    }
}
