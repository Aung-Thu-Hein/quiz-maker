<?php

namespace App;

class Quiz
{
    protected array $questions;
    protected bool $isUsedSameScore;

    //TODO:: implement next step
    // public function __construct(
    //     protected string $name,
    //     Question $question,
    //     protected bool $isUsedSameScore = false
    // )
    // {
    //     $this->questions[] = $question;
    // }

    public function addQuestion(Question $question, bool $isUsedSameScore = false): void
    {
        $this->questions[] = $question;
        $this->isUsedSameScore = $isUsedSameScore;
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
