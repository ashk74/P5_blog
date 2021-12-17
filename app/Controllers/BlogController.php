<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Validation\Validator;

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
        $posts = (new Post)->all(true);

        $this->twig->display('blog/list.twig', [
            'page_title' => 'Tous les articles - Blog',
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
            'comments' => $comments
        ]);
    }

    /* public function createComment(int $postId)
    {
        $validator = new Validator($_POST);
        $errors = $validator->validate([
            'content' => ['required', 'min:10']
        ]);

        $cleanedData = $validator->getData();
        $cleanedData['author'] = $_SESSION['userId'];
        $cleanedData['post_id'] = $postId;

        $comment = new Comment;

        $validator->flashErrors($errors, "/post/{$postId}#addComment");

        $result = $comment->create($cleanedData);

        if ($result) {
            return header("Location: /post/{$postId}#addComment");
        }
    } */
}
