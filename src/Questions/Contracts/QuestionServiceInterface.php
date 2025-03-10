<?php

namespace App\Questions\Contracts;

use App\Enums\QuestionType;
use Core\DB;

interface QuestionServiceInterface
{
    public function buildQuestion(QuestionType $questionType, array $questions): void;

    public function create(DB $createdQuiz): DB;
}
