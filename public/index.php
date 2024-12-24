<?php

use Core\App;
use Core\Container;
use Core\Router;
use App\Quizzes\Controllers\QuizController;

require_once __DIR__ . '/../vendor/autoload.php';

$container = new Container();
$router = new Router($container);

$router->get('/', function() {
    echo "Default route";
});

$router->post('/quiz', [QuizController::class, 'store']);


$app = new App(['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']], $router);
$app->run();