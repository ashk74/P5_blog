<?php

use App\Exceptions\NotFoundException;
use Router\Router;
use Tracy\Debugger;

require_once '../vendor/autoload.php';

/* Debugger::DEVELOPMENT;
Debugger::enable(); */

define('VIEWS', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR);
define('SCRIPTS', dirname($_SERVER['SCRIPT_NAME']) . DIRECTORY_SEPARATOR);

$router = new Router($_GET['url']);

$router->get('/', 'App\Controllers\BlogController@index');
$router->get('/posts', 'App\Controllers\BlogController@list');
$router->get('/post/:id', 'App\Controllers\BlogController@show');
$router->get('/tags/:id', 'App\Controllers\TagController@tag');

$router->get('/login', 'App\Controllers\UserController@login');
$router->post('/login', 'App\Controllers\UserController@loginPost');
$router->get('/logout', 'App\Controllers\UserController@logout');

$router->get('/admin/posts', 'App\Controllers\Admin\PostController@list');
$router->get('/admin/posts/create', 'App\Controllers\Admin\PostController@create');
$router->post('/admin/posts/create', 'App\Controllers\Admin\PostController@createPost');
$router->post('/admin/posts/delete/:id', 'App\Controllers\Admin\PostController@delete');
$router->get('/admin/posts/edit/:id', 'App\Controllers\Admin\PostController@edit');
$router->post('/admin/posts/edit/:id', 'App\Controllers\Admin\PostController@update');



try {
    $router->run();
} catch (NotFoundException $e) {
    return $e->error404();
}
