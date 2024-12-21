<?php

use Core\App;
use Core\Router;
use App\Controllers\HomeController;

require_once __DIR__ . '/../vendor/autoload.php';

$router = new Router();
$router->get('/', [HomeController::class, 'index']);

$app = new App(['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']], $router);
$app->run();