<?php

namespace App\Controllers;

use App\Models\Comment;
use App\Validation\Validator;

class CommentController extends Controller
{
    public function createComment(int $postId)
    {
        $validator = new Validator($_POST);
        $errors = $validator->validate([
            'content' => ['required', 'min:10']
        ]);

        $cleanedData = $validator->getData();
        $cleanedData['author'] = $_SESSION['user_id'];
        $cleanedData['post_id'] = (int) $postId;

        $comment = new Comment;

        $validator->flashErrors($errors, "/post/{$postId}#addComment");

        $result = $comment->create($cleanedData);

        if ($result) {
            return header("Location: /post/{$postId}#addComment");
        }
    }

    public function list()
    {
        $comments = (new Comment)->all(true);

        $this->twig->display('admin/comments/list.twig', [
            'page_title' => 'Modération des commentaires',
            'comments' => $comments
        ]);
    }

    public function delete(int $id)
    {
        $this->isConnected();

        $comment = (new Comment)->findById($id);
        $result = $comment->delete($id);

        if ($result) {
            return header("Location: /post/{$comment->post_id}");
        }
    }
}
