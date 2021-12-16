<?php

namespace App\Controllers\Admin;

use App\Models\Post;
use App\Models\User;
use App\Validation\Validator;
use App\Controllers\Controller;

class PostController extends Controller
{
    public function list()
    {
        $this->isConnected();
        $posts = (new Post)->all(true);

        $this->twig->display('admin/posts/index.twig', [
            'posts' => $posts,
            'page_title' => 'Administration des articles'
        ]);
    }

    public function create()
    {
        $this->isConnected();

        $authors = (new Post)->getAuthors();

        unset($_SESSION['errors']);

        $this->twig->display('admin/posts/form.twig', [
            'authors' => $authors
        ]);
    }

    public function createPost()
    {
        $this->isConnected();

        $validator = new Validator($_POST);
        $errors = $validator->validate([
            'title' => ['required', 'min:12', 'max:70'],
            'chapo' => ['required', 'min:200', 'max:600'],
            'content' => ['required', 'min:400']
        ]);

        $cleanedData = $validator->getData();

        $post = new Post;

        $result = $post->create($cleanedData);

        if ($result) {
            return header('Location: /admin/posts');
        }

        $validator->flashErrors($errors, "/admin/posts/create");
    }

    public function edit(int $id)
    {
        $this->isConnected();

        $post = (new Post)->findById($id);
        $authors = (new Post)->getAuthors();

        unset($_SESSION['errors']);

        $this->twig->display('admin/posts/form.twig', [
            'post' => $post,
            'authors' => $authors
        ]);
    }

    public function update(int $id)
    {
        $this->isConnected();

        $validator = new Validator($_POST);
        $errors = $validator->validate([
            'title' => ['required', 'min:12', 'max:70'],
            'chapo' => ['required', 'min:200', 'max:600'],
            'content' => ['required', 'min:400']
        ]);

        $cleanedData = $validator->getData();

        $post = new Post;

        $result = $post->update($id, $cleanedData);

        if ($result) {
            return header('Location: /admin/posts');
        }

        $validator->flashErrors($errors, "/admin/posts/edit/{$id}");
    }

    public function delete(int $id)
    {
        $this->isConnected();

        $post = (new Post);
        $result = $post->delete($id);

        if ($result) {
            return header('Location: /admin/posts');
        }
    }
}
