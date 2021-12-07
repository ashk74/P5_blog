<?php

use Router\Router;
use Tracy\Debugger;

require_once '../vendor/autoload.php';

Debugger::DEVELOPMENT;
Debugger::enable();

define('VIEWS', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR);
define('SCRIPTS', dirname($_SERVER['SCRIPT_NAME']) . DIRECTORY_SEPARATOR);

$router = new Router($_GET['url']);

$router->get('/', 'App\Controllers\BlogController@index');
$router->get('/posts', 'App\Controllers\BlogController@list');
$router->get('/post/:id', 'App\Controllers\BlogController@show');
$router->get('/tags/:id', 'App\Controllers\TagController@tag');

$router->run();
