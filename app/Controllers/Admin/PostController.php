<?php

namespace App\Controllers\Admin;

use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use App\Validation\Validator;
use App\Controllers\Controller;

class PostController extends Controller
{
    public function list()
    {
        $this->isAdmin();
        $posts = (new Post)->all(true);

        $this->twig->display('admin/posts/index.twig', [
            'posts' => $posts,
            'page_title' => 'Administration des articles'
        ]);
    }

    public function create()
    {
        $this->isAdmin();

        $tags = (new Tag)->all();
        $authors = (new Post)->getAuthors();

        unset($_SESSION['errors']);

        $this->twig->display('admin/posts/form.twig', [
            'tags' => $tags,
            'authors' => $authors
        ]);
    }

    public function createPost()
    {
        $this->isAdmin();

        $validator = new Validator($_POST);
        $errors = $validator->validate([
            'title' => ['required', 'min:12', 'max:70'],
            'chapo' => ['required', 'min:200', 'max:600'],
            'content' => ['required', 'min:400']
        ]);

        $post = new Post;

        $tags = array_pop($_POST);

        $result = $post->create($_POST, $tags);

        if ($result) {
            return header('Location: /admin/posts');
        }

        $validator->flashErrors($errors, "/admin/posts/create");
    }

    public function edit(int $id)
    {
        $this->isAdmin();

        $post = (new Post)->findById($id);
        $tags = (new Tag)->all();
        $authors = (new Post)->getAuthors();

        unset($_SESSION['errors']);

        $this->twig->display('admin/posts/form.twig', [
            'post' => $post,
            'tags' => $tags,
            'authors' => $authors
        ]);
    }

    public function update(int $id)
    {
        $this->isAdmin();

        $validator = new Validator($_POST);
        $errors = $validator->validate([
            'title' => ['required', 'min:12', 'max:70'],
            'chapo' => ['required', 'min:200', 'max:600'],
            'content' => ['required', 'min:400']
        ]);

        // TODO Check if $tags is null or array
        $post = new Post;
        $tags = array_pop($_POST);

        $result = $post->update($id, $_POST, $tags);

        if ($result) {
            return header('Location: /admin/posts');
        }

        $validator->flashErrors($errors, "/admin/posts/edit/{$id}");
    }

    public function delete(int $id)
    {
        $this->isAdmin();

        $post = (new Post);
        $result = $post->delete($id);

        if ($result) {
            return header('Location: /admin/posts');
        }
    }
}
