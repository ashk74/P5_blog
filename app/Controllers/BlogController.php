<?php

namespace App\Controllers;

use App\Models\Post;

class BlogController extends Controller
{
    public function index()
    {
        return $this->view('blog/index');
    }

    public function list()
    {
        $post = new Post;
        $posts = $post->all();

        return $this->view('blog/list', compact('posts'));
    }

    public function show(int $id)
    {
        $post = new Post;
        $post = $post->findById($id);

        return $this->view('blog/show', compact('post'));
    }
}
