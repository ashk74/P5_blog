<?php

namespace App\Controllers;

class BlogController extends Controller
{
    public function index()
    {
        return $this->view('blog.index');
    }

    public function list()
    {
        return $this->view('blog.list');
    }

    public function show(int $id)
    {
        return $this->view('blog.show', compact('id'));
    }
}