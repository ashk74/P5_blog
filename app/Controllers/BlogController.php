<?php

namespace App\Controllers;

use App\Models\Post;
use App\Utils\Mailer;
use App\Utils\Session;
use App\Models\Comment;
use App\Validation\Validator;

class BlogController extends Controller
{
    public function index()
    {
        Session::unsetSession('errors');
        Session::unsetSession('success');

        $this->twig->display('homepage.twig', [
            'page_title' => 'Accueil - Blog',
            'creator_name' => 'Jonathan Secher',
            'quote' => 'Dès que tu cesses d\'apprendre, tu commences à mourir.',
            'quote_author' => 'Albert Einstein',
            'token' => $this->token
        ]);
    }

    public function list()
    {
        $posts = (new Post)->all(true);

        $this->twig->display('blog/list.twig', [
            'page_title' => 'Tous les articles',
            'posts' => $posts
        ]);
    }

    public function show(int $postId)
    {
        Session::unsetSession('errors');
        Session::unsetSession('success');

        $post = (new Post)->findById($postId);
        $comments = (new Comment)->linkedComments($postId);

        $this->twig->display('blog/show.twig', [
            'post' => $post,
            'comments' => $comments,
            'token' => $this->token
        ]);
    }

    public function contactPost()
    {
        $validator = new Validator($_POST);
        $errors = $validator->validate([
            'firstname' => ['required', 'min:2', 'max:70'],
            'lastname' => ['required', 'min:2', 'max:70'],
            'email' => ['required', 'email'],
            'message' => ['required', 'min:100'],
            'token' => ['required', 'token']
        ]);

        if (!$errors) {
            $cleanedData = $validator->getData();
            $cleanedData['fullname'] = $cleanedData['firstname'] . ' ' . $cleanedData['lastname'];
            (new Mailer)->sendMail($cleanedData);
            $_SESSION['success'] = true;
            header('Location: /');
        } else {
            $validator->flashErrors($errors, '/');
        }
    }
}
