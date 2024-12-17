<?php

namespace App\Questions;

use App\Questions\Builders\MultipleChoiceQuestionBuilder;
use App\Questions\Contracts\Question;

class MultipleChoiceQuestion implements Question
{
    protected string $body;
    protected array $options;
    protected array $solutions;
    protected int $score;

    public static function make(): MultipleChoiceQuestionBuilder
    {
        return new MultipleChoiceQuestionBuilder();
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getSolutions(): array
    {
        return $this->solutions;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function checkAnswer(mixed $answer): bool
    {
        if (empty($answer)) return false;

        if (sort($this->solutions) == sort($answer)) {
            return true;
        } else {
            return false;
        }
    }
}
