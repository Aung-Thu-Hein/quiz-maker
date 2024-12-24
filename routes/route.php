<?php

use App\Quizzes\Controllers\QuizController;

$router->get('/', function() {
    echo "Default route";
});

$router->post('/quiz', [QuizController::class, 'store']);
