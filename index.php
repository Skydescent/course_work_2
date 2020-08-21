<?php

use App\View;
use App\Router;
use App\Model;
use App\Application;
use App\Controller;


error_reporting(E_ALL);
ini_set('display_errors',true);


require_once 'bootstrap.php';


$router = new Router();


$router->request('/post/*', Controller\PostController::class . '@post');
$router->request('/', Controller\MainController::class . '@index');
$router->request('/*/*');

$application = new Application($router);

$application->run();