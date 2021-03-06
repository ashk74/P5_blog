<?php

use App\Exceptions\NotFoundException;
use Router\Router;

require_once '../vendor/autoload.php';

define('STYLESHEET', DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'style.css');
define('IMAGES', DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR);
define('AVATARS', DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'avatars' . DIRECTORY_SEPARATOR);

// Used in homepage.twig
define('CREATOR_NAME', 'Jonathan Secher');
define('QUOTE', 'Dès que tu cesses d\'apprendre, tu commences à mourir.');
define('QUOTE_AUTHOR', 'Albert Einstein');

// Used in layout.twig
define('GITHUB_LINK', 'https://github.com/ashk74');
define('LINKEDIN_LINK', 'https://www.linkedin.com/in/jonathan-secher-43b851225');
define('TWITTER_LINK', 'https://twitter.com/jonathan_secher');

$router = new Router($_GET['url']);

// Homepage
$router->get('/', 'App\Controllers\BlogController@index');
$router->post('/', 'App\Controllers\BlogController@contactPost');

// Posts controllers
$router->get('/posts', 'App\Controllers\BlogController@list');
$router->get('/post/:id', 'App\Controllers\BlogController@show');

// Comment controller
$router->post('/post/:id', 'App\Controllers\CommentController@createComment');
$router->post('/comment/delete/:id', 'App\Controllers\CommentController@delete');

// Users controllers
$router->get('/signup', 'App\Controllers\UserController@signup');
$router->post('/signup', 'App\Controllers\UserController@signupPost');
$router->get('/login', 'App\Controllers\UserController@login');
$router->post('/login', 'App\Controllers\UserController@loginPost');
$router->get('/logout', 'App\Controllers\UserController@logout');

// Admin : Posts controllers
$router->get('/admin/posts', 'App\Controllers\Admin\PostController@list');
$router->get('/admin/posts/create', 'App\Controllers\Admin\PostController@create');
$router->post('/admin/posts/create', 'App\Controllers\Admin\PostController@createPost');
$router->post('/admin/posts/delete/:id', 'App\Controllers\Admin\PostController@delete');
$router->get('/admin/posts/edit/:id', 'App\Controllers\Admin\PostController@edit');
$router->post('/admin/posts/edit/:id', 'App\Controllers\Admin\PostController@editPost');

// Admin : Comments controllers
$router->get('/admin/comments', 'App\Controllers\Admin\CommentController@list');
$router->get('/admin/comments/not-moderated', 'App\Controllers\Admin\CommentController@listNotModerated');
$router->get('/admin/comments/moderate', 'App\Controllers\Admin\CommentController@listModerated');
$router->post('/admin/comments/delete/:id', 'App\Controllers\Admin\CommentController@delete');
$router->post('/admin/comments/moderate/:id', 'App\Controllers\Admin\CommentController@moderate');

// Admin : Users controllers
$router->get('/admin/users', 'App\Controllers\Admin\UserController@list');
$router->get('/admin/users/no-validate', 'App\Controllers\Admin\UserController@listNotValidated');
$router->get('/admin/users/validate', 'App\Controllers\Admin\UserController@listValidate');
$router->get('/admin/users/admins', 'App\Controllers\Admin\UserController@listAdmin');
$router->post('/admin/users/delete/:id', 'App\Controllers\Admin\UserController@delete');
$router->post('/admin/users/validate/:id', 'App\Controllers\Admin\UserController@validateUser');
$router->post('/admin/users/update-admin-role/:id', 'App\Controllers\Admin\UserController@updateAdminRole');

try {
    $router->run();
} catch (NotFoundException $e) {
    return $e->error404();
}
