<?php

namespace App\Controllers;

use App\Models\Post;

class BlogController extends Controller
{
    public function index()
    {
        $this->twig->display('homepage.twig', [
            'page_title' => 'Accueil - Blog',
            'creator_name' => 'Jonathan Secher',
            'quote' => 'Dès que tu cesses d\'apprendre, tu commences à mourir.',
            'quote_author' => 'Albert Einstein'
        ]);
    }

    public function list()
    {
        $post = new Post;
        $posts = $post->all(true);

        $this->twig->display('blog/list.twig', [
            'page_title' => 'Tous les articles - Blog',
            'posts' => $posts
        ]);
    }

    public function show(int $id)
    {
        $post = new Post;
        $post = $post->findById($id);

        $this->twig->display('blog/show.twig', [
            'post' => $post
        ]);
    }
}
