<?php

namespace App\Questions;

use App\Questions\Builders\SingleChoiceQuestionBuilder;

class SingleChoiceQuestion extends Question
{
    public static function make(): SingleChoiceQuestionBuilder
    {
        return new SingleChoiceQuestionBuilder();
    }

    public function checkAnswer(mixed $answer): bool
    {
        if (!$answer) return false;

        if ($answer !== $this->solution) return false;

        return true;
    }
}
