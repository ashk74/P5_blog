<?php

namespace App\Controllers\Admin;

use App\Models\Post;
use App\Utils\Session;
use App\Validation\Validator;
use App\Controllers\Controller;

class PostController extends Controller
{
    private array $postInfos;

    public function list()
    {
        $this->isValidate();

        Session::unsetSession('errors');
        Session::unsetSession('success');

        $posts = (new Post)->all(true);

        $this->twig->display('admin/posts/list.twig', [
            'posts' => $posts,
            'page_title' => 'Administration des articles',
            'token' => $this->token
        ]);
    }

    public function create()
    {
        $this->isValidate();

        $authors = (new Post)->getAuthors();

        Session::unsetSession('errors');
        Session::unsetSession('success');

        $this->twig->display('admin/posts/form.twig', [
            'authors' => $authors,
            'token' => $this->token
        ]);
    }

    public function createPost()
    {
        $this->isValidate();

        $validator = new Validator($_POST);
        $errors = $validator->validate([
            'title' => ['required', 'min:12', 'max:70'],
            'chapo' => ['required', 'min:200', 'max:600'],
            'content' => ['required', 'min:400'],
            'token' => ['token', 'required']
        ]);

        if (!$errors) {
            $this->postInfos = $validator->getData();
            $this->postInfos = array_slice($this->postInfos, -5, 4);

            $post = new Post;

            $result = $post->create($this->postInfos);

            if ($result) {
                return header('Location: /admin/posts');
            }
        } else {
            $validator->flashErrors($errors, "/admin/posts/create");
        }
    }

    public function edit(int $id)
    {
        $this->isValidate();

        $post = (new Post)->findById($id);
        $authors = (new Post)->getAuthors();

        Session::unsetSession('errors');
        Session::unsetSession('success');

        $this->twig->display('admin/posts/form.twig', [
            'post' => $post,
            'authors' => $authors,
            'token' => $this->token
        ]);
    }

    public function editPost(int $id)
    {
        $this->isValidate();

        $validator = new Validator($_POST);
        $errors = $validator->validate([
            'title' => ['required', 'min:12', 'max:70'],
            'chapo' => ['required', 'min:200', 'max:600'],
            'content' => ['required', 'min:400'],
            'token' => ['required', 'token']
        ]);

        if (!$errors) {
            $this->postInfos = $validator->getData();
            $this->postInfos = array_slice($this->postInfos, -5, 4);

            $result = (new Post)->update($id, $this->postInfos);

            if ($result) {
                return header('Location: /admin/posts');
            }
        } else {
            $validator->flashErrors($errors, "/admin/posts/edit/{$id}");
        }
    }

    public function delete(int $id)
    {
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
