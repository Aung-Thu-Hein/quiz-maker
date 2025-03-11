<?php

namespace App\Questions\Factories;

use App\Enums\QuestionType;
use App\Questions\MultipleChoiceQuestion;
use App\Questions\Question;
use App\Questions\SingleChoiceQuestion;

class QuestionFactory
{
    public static function create(QuestionType $questionType): Question
    {
        return match($questionType) {
            QuestionType::SINGLE_CHOICE => new SingleChoiceQuestion(),
            QuestionType::MULTIPLE_CHOICE => new MultipleChoiceQuestion(),
            default => throw new \InvalidArgumentException("Cannot create question, due to invalid question type")
        };
    }
}
