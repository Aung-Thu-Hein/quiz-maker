<?php

namespace App\Questions;

use App\Questions\Builders\SingleChoiceQuestionBuilder;
use App\Questions\Contracts\Question;

class SingleChoiceQuestion implements Question
{
    protected string $body;
    protected string $solution;
    protected array $options;
    protected int $score;

    public static function make(): SingleChoiceQuestionBuilder
    {
        return new SingleChoiceQuestionBuilder();
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getSolution(): string
    {
        return $this->solution;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function checkAnswer(mixed $answer): bool
    {
        if (!$answer) return false;

        if ($answer !== $this->solution) return false;

        return true;
    }
}
