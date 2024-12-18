<?php

namespace App\Questions;

abstract class Question
{
    protected string $body;
    protected array $options;
    protected mixed $solution;
    protected int $score;

    abstract public function checkAnswer(mixed $answer): bool;

    public function getBody(): string 
    {
        return $this->body;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getSolution(): mixed
    {
        return $this->solution;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    public function setSolution(mixed $solution): void
    {
        $this->solution = $solution;
    }

    public function setScore(int $score): void
    {
        $this->score = $score;
    }
}
