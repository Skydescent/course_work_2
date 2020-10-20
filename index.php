<?php

use App\Router;
use App\Application;
use App\Controller;

error_reporting(E_ALL);
ini_set('display_errors',true);

require_once 'bootstrap.php';

$router = new Router();

$router->request('/post/edit/*', Controller\PostController::class . '@edit');
$router->request('/post/new', Controller\PostController::class . '@new');
$router->request('/post/*', Controller\PostController::class . '@post');
$router->request('/', Controller\MainController::class . '@index');

$router->request('/user/login', Controller\UserController::class . '@login');
$router->request('/user/signup', Controller\UserController::class . '@signup');
$router->request('/user/profile', Controller\UserController::class . '@profile');
$router->request('/user/logout', Controller\UserController::class . '@logout');

$router->request('/admin/users', Controller\AdminController::class . '@users');
$router->request('/admin/posts', Controller\AdminController::class . '@posts');
$router->request('/admin/subscriptions', Controller\AdminController::class . '@subscriptions');
$router->request('/admin/comments', Controller\AdminController::class . '@comments');
$router->request('/admin/pages', Controller\AdminController::class . '@pages');
$router->request('/admin/settings', Controller\AdminController::class . '@settings');

$router->request('/page/*', Controller\StaticController::class . '@page');

$application = new Application($router);

$application->run();