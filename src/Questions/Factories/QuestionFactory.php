<?php

namespace App\Questions\Factories;

use App\Enums\QuestionType;
use App\Questions\MultipleChoiceQuestion;
use App\Questions\SingleChoiceQuestion;

class QuestionFactory
{
    public static function create(int $questionType)
    {
        return match($questionType) {
            QuestionType::SINGLE_CHOICE->value => new SingleChoiceQuestion(),
            QuestionType::MULTIPLE_CHOICE->value => new MultipleChoiceQuestion(),
            default => throw new \InvalidArgumentException("Cannot create question, due to invalid question type")
        };
    }
}
