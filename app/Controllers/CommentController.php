<?php

namespace App\Controllers;

use App\Models\Comment;
use App\Validation\Validator;

class CommentController extends Controller
{
    public function createComment(int $postId)
    {
        $this->isConnected();

        $validator = new Validator($_POST);
        $errors = $validator->validate([
            'content' => ['required', 'min:10'],
            'token' => ['required', 'token']
        ]);

        if (!$errors) {
            $cleanedData = $validator->getData();
            $cleanedData['author'] = $_SESSION['user_id'];
            $cleanedData['post_id'] = (int) $postId;

            $comment = new Comment;
            $result = $comment->create($cleanedData);

            if ($result) {
                return header("Location: /post/{$postId}?success=true/#addComment");
            }
        } else {
            $validator->flashErrors($errors, "/post/{$postId}#addComment");
        }
    }

    public function delete(int $id)
    {
        $this->isConnected();

        $validator = new Validator($_POST);
        $errors = $validator->validate([
            'content' => ['required', 'min:10'],
            'token' => ['required', 'token']
        ]);

        $comment = (new Comment)->findById($id);

        if (!$errors) {

            $result = $comment->delete($id);

            if ($result) {
                return header("Location: /post/{$comment->post_id}");
            }
        } else {
            $validator->flashErrors($errors, "/post/{$comment->post_id}");
        }
    }
}
