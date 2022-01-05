<?php

namespace App\Controllers;

use App\Models\Post;
use App\Utils\Mailer;
use App\Utils\Session;
use App\Models\Comment;
use App\Validation\Validator;

class BlogController extends Controller
{
    /**
     * Display : Homepage with contact form
     *
     * @return void
     */
    public function index(): void
    {
        // Remove session array
        Session::unsetSession('errors');
        Session::unsetSession('success');

        // Send parameters to the layout for display with Twig
        $this->twig->display('homepage.twig', [
            'page_title' => 'Accueil - Blog',
            'token' => $this->token
        ]);
    }

    /**
     * Display : All posts
     *
     * @return void
     */
    public function list(): void
    {
        // Retrieve all posts order by DESC
        $posts = (new Post)->all(true);

        // Send parameters to the layout for display with Twig
        $this->twig->display('blog/list.twig', [
            'page_title' => 'Tous les articles',
            'posts' => $posts
        ]);
    }

    /**
     * Display : Post details
     *
     * @param integer $postId ID of the post to recover
     *
     * @return void
     */
    public function show(int $postId): void
    {
        // Remove session array
        Session::unsetSession('errors');
        Session::unsetSession('success');

        // Retrieve post by ID and linked comments
        $post = (new Post)->findById($postId);
        $comments = (new Comment)->linkedComments($postId);

        // Send parameters to the layout for display with Twig
        $this->twig->display('blog/show.twig', [
            'post' => $post,
            'comments' => $comments,
            'token' => $this->token
        ]);
    }

    /**
     * Validate form : Contact
     *
     * @return void
     */
    public function contactPost(): void
    {
        // Send user data to the validator
        $validator = new Validator($_POST);
        $errors = $validator->validate([
            'firstname' => ['required', 'min:2', 'max:70'],
            'lastname' => ['required', 'min:2', 'max:70'],
            'email' => ['required', 'email'],
            'message' => ['required', 'min:100'],
            'token' => ['required', 'token']
        ]);

        // Check errors and send email
        if (!$errors) {
            $cleanedData = $validator->getSanitizedData();
            $cleanedData['fullname'] = $cleanedData['firstname'] . ' ' . $cleanedData['lastname'];
            (new Mailer)->sendMail($cleanedData);
            $_SESSION['success'] = true;
            header('Location: /');
        } else {
            $validator->flashErrors($errors, '/');
        }
    }
}
