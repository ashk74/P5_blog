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

        unset($_SESSION['errors']);
        $posts = (new Post)->all(true);

        $this->twig->display('admin/posts/list.twig', [
            'posts' => $posts,
            'page_title' => 'Administration des articles',
            'token' => $this->token
        ]);
    }

    public function create()
    {
        $this->isConnected();
        $this->isValidate();

        $authors = (new Post)->getAuthors();

        unset($_SESSION['errors']);

        $this->twig->display('admin/posts/form.twig', [
            'authors' => $authors,
            'token' => $this->token
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
            'content' => ['required', 'min:400'],
            'token' => ['token', 'required']
        ]);

        $cleanedData = $validator->getData();

        if (!$errors) {
            $post = new Post;

            $result = $post->create($cleanedData);

            if ($result) {
                return header('Location: /admin/posts');
            }
        } else {
            $validator->flashErrors($errors, "/admin/posts/create");
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
            'authors' => $authors,
            'token' => $this->token
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
            'content' => ['required', 'min:400'],
            'token' => ['required', 'token']
        ]);

        $cleanedData = $validator->getData();

        if (!$errors) {
            $result = (new Post)->update($id, $cleanedData);

            if ($result) {
                return header('Location: /admin/posts');
            }
        } else {
            $validator->flashErrors($errors, "/admin/posts/edit/{$id}");
        }
    }

    public function delete(int $id)
    {
        $this->isConnected();
        $this->isValidate();

        $validator = new Validator($_POST);

        $errors = $validator->validate([
            'token' => ['required', 'token']
        ]);

        if (!$errors) {
            $result = (new Post)->delete($id);

            if ($result) {
                return header('Location: /admin/posts');
            }
        } else {
            $validator->flashErrors($errors, "/admin/posts");
        }
    }
}
