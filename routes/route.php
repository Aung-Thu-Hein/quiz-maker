<?php

use App\Quizzes\Controllers\QuizController;
use Core\Container;
use Core\DB;

$router->get('/', function() {
    echo "Default route";
});

$router->post('/quiz', [QuizController::class, 'store']);
