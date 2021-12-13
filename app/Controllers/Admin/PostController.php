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

        return $this->view('admin/post/index', compact('posts'));
    }

    public function create()
    {
        $this->isAdmin();

        $tags = (new Tag)->all();

        return $this->view('admin/post/form', compact('tags'));
    }

    public function createPost()
    {
        $this->isAdmin();

        $post = new Post;

        $tags = array_pop($_POST);

        $result = $post->create($_POST, $tags);

        if ($result) {
            return header('Location: /admin/posts');
        }
    }

    public function edit(int $id)
    {
        $this->isAdmin();

        $post = (new Post)->findById($id);
        $tags = (new Tag)->all();
        $authors = (new User)->all();

        return $this->view('admin/post/form', compact('post', 'tags', 'authors'));
    }

    public function update(int $id)
    {
        $this->isAdmin();

        $validator = new Validator($_POST);
        $errors = $validator->validate([
            'title' => ['required', 'min:12', 'max:70'],
            'chapo' => ['required', 'min:200', 'max:600'],
            'content' => ['required', 'min:200']
        ]);

        Validator::flashErrors($errors, "/admin/posts/edit/{$id}");

        // TODO Check if $tags is null or array
        $post = new Post;
        $tags = array_pop($_POST);

        $result = $post->update($id, $_POST, $tags);

        if ($result) {
            return header('Location: /admin/posts');
        }
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
