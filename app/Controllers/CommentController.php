<?php

namespace App\Controllers;

use App\Models\Comment;
use App\Validation\Validator;

class CommentController extends Controller
{
    public array $content;

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
            // Exclude token from the SQL request
            $this->content = array_slice($cleanedData, -2, 1);
            $this->content['author'] = (int) $_SESSION['user_id'];
            $this->content['post_id'] = (int) $postId;

            $comment = new Comment;
            $result = $comment->create($this->content);

            if ($result) {
                $_SESSION['success'] = true;
                return header("Location: /post/{$postId}");
            }
        } else {
            $validator->flashErrors($errors, "/post/{$postId}");
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
