<?php

namespace App\Controllers;

use App\Models\Comment;
use App\Validation\Validator;

class CommentController extends Controller
{
    public array $content;

    /**
     * Validate form : Create new comment
     *
     * @param integer $postId ID of the post to link comment
     *
     * @return void
     */
    public function createComment(int $postId)
    {
        // Check user is connected
        $this->isConnected();

        // Send user data to the validator
        $validator = new Validator($_POST);
        $errors = $validator->validate([
            'content' => ['required', 'min:10'],
            'token' => ['required', 'token']
        ]);

        // Check errors and create new comment
        if (!$errors) {
            $cleanedData = $validator->getSanitizedData();
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

    /**
     * Validate form : Delete comment
     *
     * @param integer $id ID of the comment to be deleted
     *
     * @return void
     */
    public function delete(int $id)
    {
        // Check user is connected
        $this->isConnected();

        // Send user data to the validator
        $validator = new Validator($_POST);
        $errors = $validator->validate([
            'token' => ['required', 'token']
        ]);

        // Retrieve comment by ID
        $comment = (new Comment)->findById($id);

        // Check errors and delete comment
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
