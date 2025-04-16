<?php

use App\Questions\Controllers\QuestionController;
use App\Quizzes\Controllers\QuizController;
use App\Users\Controllers\UserController;

$router->get('/', function() {
    echo "This is " .config('app')['name'];
});

$router->get('/quizzes', [QuizController::class, 'index']);
$router->get('/quizzes/{id}', [QuizController::class, 'show']);
$router->post('/quizzes', [QuizController::class, 'store']);
$router->put('/quizzes/{id}', [QuizController::class, 'update']);
$router->delete('/quizzes/{id}', [QuizController::class, 'delete']);

$router->get('/quizzes/{quiz_id}/questions/{id}', [QuestionController::class, 'show']);
$router->post('/quizzes/{quiz_id}/questions', [QuestionController::class, 'store']);
$router->put('/quizzes/{quiz_id}/questions/{id}', [QuestionController::class, 'update']);
$router->delete('/quizzes/{quiz_id}/questions/{id}', [QuestionController::class, 'delete']);

$router->post('/users/register', [UserController::class, 'store']);
$router->post('/users/login', [UserController::class, 'login']);
$router->post('/users/logout', [UserController::class, 'logout']);
$router->post('/auth/refresh', [UserController::class, 'refresh']);