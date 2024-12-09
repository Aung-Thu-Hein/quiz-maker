<?php

namespace App;

class Question
{
    protected string $answer;

    public function __construct(
        protected string $body,
        protected string $solution,
        protected ?int $score = null
    ) {}

    public function getBody(): string
    {
        return $this->body;
    }

    public function getSolution(): string
    {
        return $this->solution;
    }

    public function getAnswer(): string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): void
    {
        $this->answer = $answer;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function isCorrect(): bool
    {
        if (!isset($this->answer)) return false;

        return  $this->solution === $this->answer;
    }
}
