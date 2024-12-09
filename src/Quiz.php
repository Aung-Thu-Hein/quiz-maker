<?php

namespace App;

class Quiz
{
    protected array $questions;
    protected ?int $commonScore = null;

    public function __construct(
        protected string $name,
        Question $question,
        protected bool $isUsedSameScore = false
    ) {
        if ($isUsedSameScore) {
            $this->commonScore = $question->getScore();
        }

        $this->questions[] = $question;
    }

    public function addQuestion(Question $question): void
    {
        if ($this->isUsedSameScore && $this->commonScore) {
            $question = new Question($question->getBody(), $question->getSolution(), $this->commonScore);
        }

        $this->questions[] = $question;
    }

    public function getQuestions(): array
    {
        return $this->questions;
    }

    public function calculateUserScore(): int
    {
        return array_reduce(
            $this->questions,
            fn($correctScore, $question) => $correctScore += $question->isCorrect() ? $question->getScore() : 0,
            0
        );
    }

    public function calculateTotalScore(): int
    {
        return array_reduce(
            $this->questions,
            fn($totalScore, $question) => $totalScore += $question->getScore(),
            0
        );
    }
}
