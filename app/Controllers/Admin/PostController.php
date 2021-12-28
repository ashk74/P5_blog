<?php

namespace App\Controllers\Admin;

use App\Models\Post;
use App\Utils\Session;
use App\Validation\Validator;
use App\Controllers\Controller;

class PostController extends Controller
{
    private array $postInfos;

    /**
     * Display : All posts
     *
     * @return void
     */
    public function list()
    {
        // Check validated user
        $this->isValidated();

        // Remove session array
        Session::unsetSession('errors');
        Session::unsetSession('success');

        // Retrieve all posts
        $posts = (new Post)->all(true);

        // Send parameters to the layout for display with Twig
        $this->twig->display('admin/posts/list.twig', [
            'posts' => $posts,
            'page_title' => 'Administration des articles',
            'token' => $this->token
        ]);
    }

    /**
     * Display form : Create new post
     *
     * @return void
     */
    public function create()
    {
        // Check validated user
        $this->isValidated();

        // Remove session array
        Session::unsetSession('errors');
        Session::unsetSession('success');

        // Retrieve all authors
        $authors = (new Post)->getAuthors();

        // Send parameters to the layout for display with Twig
        $this->twig->display('admin/posts/form.twig', [
            'authors' => $authors,
            'token' => $this->token
        ]);
    }

    /**
     * Validate form : Create new post
     *
     * @return void
     */
    public function createPost()
    {
        // Check validated user
        $this->isValidated();

        // Send user data to the validator
        $validator = new Validator($_POST);
        $errors = $validator->validate([
            'title' => ['required', 'min:12', 'max:70'],
            'chapo' => ['required', 'min:200', 'max:600'],
            'content' => ['required', 'min:400'],
            'token' => ['token', 'required']
        ]);

        // Check errors and create new post
        if (!$errors) {
            $this->postInfos = $validator->getSanitizedData();
            $this->postInfos = array_slice($this->postInfos, -5, 4);

            $result = (new Post)->create($this->postInfos);

            if ($result) {
                return header('Location: /admin/posts');
            }
        } else {
            $validator->flashErrors($errors, "/admin/posts/create");
        }
    }

    /**
     * Display form : Edit existing post
     *
     * @param integer $id ID of the post to edit
     *
     * @return void
     */
    public function edit(int $id)
    {
        // Check validated user
        $this->isValidated();

        // Remove session array
        Session::unsetSession('errors');
        Session::unsetSession('success');

        // Retrieve post by ID and all authors
        $post = (new Post)->findById($id);
        $authors = (new Post)->getAuthors();

        // Send parameters to the layout for display with Twig
        $this->twig->display('admin/posts/form.twig', [
            'post' => $post,
            'authors' => $authors,
            'token' => $this->token
        ]);
    }

    /**
     * Validate form : Edit existing post
     *
     * @param integer $id ID of the post to update
     *
     * @return void
     */
    public function editPost(int $id)
    {
        // Check validated user
        $this->isValidated();

        // Send user data to the validator
        $validator = new Validator($_POST);
        $errors = $validator->validate([
            'title' => ['required', 'min:12', 'max:70'],
            'chapo' => ['required', 'min:200', 'max:600'],
            'content' => ['required', 'min:400'],
            'token' => ['required', 'token']
        ]);

        // Check errors and edit existing post
        if (!$errors) {
            $this->postInfos = $validator->getSanitizedData();
            $this->postInfos = array_slice($this->postInfos, -5, 4);

            $result = (new Post)->update($id, $this->postInfos);

            if ($result) {
                return header('Location: /admin/posts');
            }
        } else {
            $validator->flashErrors($errors, "/admin/posts/edit/{$id}");
        }
    }

    /**
     * Validate form : Delete post
     *
     * @param integer $id ID of the post to delete
     *
     * @return void
     */
    public function delete(int $id)
    {
        // Check validated user
        $this->isValidated();

        // Send user data to the validator
        $validator = new Validator($_POST);
        $errors = $validator->validate([
            'token' => ['required', 'token']
        ]);

        // Check errors and delete post
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
