<?php

use App\Quizzes\Controllers\QuizController;

$router->get('/', function() {
    echo "Default route";
});

$router->get('/quiz', [QuizController::class, 'index']);
$router->post('/quiz', [QuizController::class, 'store']);
