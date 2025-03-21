<?php

use App\Questions\Controllers\QuestionController;
use App\Quizzes\Controllers\QuizController;

$router->get('/', function() {
    echo "This is " .config('app')['name'];
});

$router->get('/quizzes', [QuizController::class, 'index']);
$router->get('/quizzes/{id}', [QuizController::class, 'show']);
$router->post('/quizzes', [QuizController::class, 'store']);
$router->put('/quizzes/{id}', [QuizController::class, 'update']);
$router->patch('/quizzes/{id}', [QuizController::class, 'patch']);
$router->delete('/quizzes/{id}', [QuizController::class, 'delete']);

$router->get('/quizzes/{quiz_id}/questions', [QuestionController::class, 'index']);
$router->get('/quizzes/{quiz_id}/questions/{id}', [QuestionController::class, 'show']);
$router->post('/quizzes/{quiz_id}/questions', [QuestionController::class, 'storeQuestions']);
$router->put('/quizzes/{quiz_id}/questions/{id}', [QuestionController::class, 'update']);
$router->patch('/quizzes/{quiz_id}/questions/{id}', [QuestionController::class, 'patch']);
$router->delete('/quizzes/{quiz_id}/questions/{id}', [QuestionController::class, 'delete']);
