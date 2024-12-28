<?php

use App\Quizzes\Controllers\QuizController;

$router->get('/', function() {
    echo "Automate CI test";
});

$router->get('/quiz', [QuizController::class, 'index']);
$router->post('/quiz', [QuizController::class, 'store']);
