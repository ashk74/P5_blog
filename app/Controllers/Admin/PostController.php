<?php

namespace App\Controllers\Admin;

use App\Models\Post;
use App\Validation\Validator;
use App\Controllers\Controller;

class PostController extends Controller
{
    public function list()
    {
        $this->isConnected();
        $this->isValidate();

        $posts = (new Post)->all(true);

        $this->twig->display('admin/posts/list.twig', [
            'posts' => $posts,
            'page_title' => 'Administration des articles'
        ]);
    }

    public function create()
    {
        $this->isConnected();
        $this->isValidate();

        $authors = (new Post)->getAuthors();

        unset($_SESSION['errors']);

        $this->twig->display('admin/posts/form.twig', [
            'authors' => $authors
        ]);
    }

    public function createPost()
    {
        $this->isConnected();
        $this->isValidate();

        $validator = new Validator($_POST);
        $errors = $validator->validate([
            'title' => ['required', 'min:12', 'max:70'],
            'chapo' => ['required', 'min:200', 'max:600'],
            'content' => ['required', 'min:400']
        ]);

        $cleanedData = $validator->getData();

        $post = new Post;

        $validator->flashErrors($errors, "/admin/posts/create");

        $result = $post->create($cleanedData);

        if ($result) {
            return header('Location: /admin/posts');
        }
    }

    public function edit(int $id)
    {
        $this->isConnected();
        $this->isValidate();

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
        $this->isValidate();

        $validator = new Validator($_POST);
        $errors = $validator->validate([
            'title' => ['required', 'min:12', 'max:70'],
            'chapo' => ['required', 'min:200', 'max:600'],
            'content' => ['required', 'min:400']
        ]);

        $cleanedData = $validator->getData();

        $result = (new Post)->update($id, $cleanedData);

        if ($result) {
            return header('Location: /admin/posts');
        }

        $validator->flashErrors($errors, "/admin/posts/edit/{$id}");
    }

    public function delete(int $id)
    {
        $this->isConnected();
        $this->isValidate();

        $result = (new Post)->delete($id);

        if ($result) {
            return header('Location: /admin/posts');
        }
    }
}
