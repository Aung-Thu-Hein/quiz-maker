<?php

namespace App\Quizzes;

use App\Questions\Question;
use App\Quizzes\Builders\QuizBuilder;

class Quiz
{
    protected string $name;
    protected array $questions;
    protected bool $isUsedSameScore;
    protected int $questionType;

    public function getName(): string
    {
        return $this->name;
    }

    public function getQuestions(): array
    {
        return $this->questions;
    }

    public function getIsUsedSameScore(): bool
    {
        return $this->isUsedSameScore;
    }

    public function getQuestionType(): int
    {
        return $this->questionType;
    }

    public static function make(): QuizBuilder
    {
        return new QuizBuilder();
    }

    public function addQuestion(Question $question): void
    {
        $this->questions[] = $question;
    }

    //TODO:: no use, later modify logic
    public function calculateUserScore(): int
    {
        return array_reduce(
            $this->questions,
            fn($correctScore, $question) => $correctScore += $question->checkAnswer() ? $question->getScore() : 0,
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
