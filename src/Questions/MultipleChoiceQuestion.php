<?php

namespace App\Questions;

use App\Questions\Builders\MultipleChoiceQuestionBuilder;

class MultipleChoiceQuestion extends Question
{
    public static function make(): MultipleChoiceQuestionBuilder
    {
        return new MultipleChoiceQuestionBuilder();
    }

    public function checkAnswer(mixed $answer): bool
    {
        if (empty($answer)) return false;

        if (sort($this->solution) == sort($answer)) {
            return true;
        } else {
            return false;
        }
    }
}
