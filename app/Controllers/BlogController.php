<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\Comment;

class BlogController extends Controller
{
    public function index()
    {
        if (isset($_SESSION['errors'])) {
            unset($_SESSION['errors']);
        }
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
        unset($_SESSION['errors']);
        $post = (new Post)->findById($postId);
        $comments = (new Comment)->fetchLinkedComments($postId);

        $this->twig->display('blog/show.twig', [
            'post' => $post,
            'comments' => $comments,
            'token' => $this->token
        ]);
    }
}
