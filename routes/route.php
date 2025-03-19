<?php

use App\Questions\Controllers\QuestionController;
use App\Quizzes\Controllers\QuizController;

$router->get('/', function() {
    echo "Automate CI test";
});

$router->get('/quiz', [QuizController::class, 'index']);
$router->get('/quiz/{id}', [QuizController::class, 'show']);
$router->post('/quiz', [QuizController::class, 'store']);
$router->put('/quiz/{id}', [QuizController::class, 'update']);
$router->patch('/quiz/{id}', [QuizController::class, 'patch']);
$router->delete('/quiz/{id}', [QuizController::class, 'delete']);

$router->get('/quiz/{quiz_id}/questions', [QuestionController::class, 'index']);
$router->get('/quiz/{quiz_id}/questions/{id}', [QuestionController::class, 'show']);
$router->post('/quiz/{quiz_id}/questions', [QuestionController::class, 'storeQuestions']);
$router->put('/quiz/{quiz_id}/questions/{id}', [QuestionController::class, 'update']);
$router->patch('/quiz/{quiz_id}/questions/{id}', [QuestionController::class, 'patch']);
$router->delete('/quiz/{quiz_id}/questions/{id}', [QuestionController::class, 'delete']);
