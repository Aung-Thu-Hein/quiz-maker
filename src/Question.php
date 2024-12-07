<?php

namespace App;

class Question
{
    protected mixed $answer;

    public function __construct(
        protected string $body, 
        protected mixed $solution,
        protected int $score
    ) {}

    public function answer(mixed $answer): void
    {
        $this->answer = $answer;
    }

    public function isCorrect(): bool
    {
        if(!isset($this->answer)) return false;

        return  $this->solution === $this->answer;
    }

    public function getScore(): int
    {
        return $this->score;
    }
}
