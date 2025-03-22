<?php

namespace App\Quizzes\Contracts;

use App\Quizzes\Models\Quiz;
use Core\DB;
use Core\Http\Request;

interface QuizServiceInterface
{
    public function buildQuiz(Request $request);

    public function getAllQuizzes(): array;

    public function getQuiz(int $id): array|false;

    public function createQuiz(): Quiz;

    public function updateQuiz(int $id, Request $request): int|false;

    public function deleteQuiz(int $id): int|false;
}
