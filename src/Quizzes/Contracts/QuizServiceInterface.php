<?php

namespace App\Quizzes\Contracts;

use Core\DB;

interface QuizServiceInterface
{
    public function buildQuiz(array $request);

    public function create(): DB;
}
