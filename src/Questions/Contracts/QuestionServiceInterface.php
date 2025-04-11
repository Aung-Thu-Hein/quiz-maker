<?php

namespace App\Questions\Contracts;

use App\Questions\Question;
use Core\Http\Request;

interface QuestionServiceInterface
{
    public function buildQuestion(Request $request): void;

    public function getQuestion(int $id, int $quiz_id): false|array;

    public function createQuestion(int $quiz_id): Question;

    public function createQuestions(int $quiz_id, Request $request): bool;

    public function updateQuestion(int $id, int $quiz_id, Request $request): int|false;

    public function deleteQuestion(int $id, int $quiz_id): bool;
}
