<?php

namespace App\Quizzes\Models;

use App\Enums\QuestionType;
use App\Questions\Question;
use App\Quizzes\Models\Builders\QuizBuilder;

class Quiz
{
    protected ?int $id = null;
    protected string $name;
    protected array $questions;
    protected bool $isUsedSameScore;
    protected QuestionType $questionType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

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

    public function getQuestionType(): QuestionType
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

    public function addQuestions(array $questions): void
    {
        $this->questions = $questions;
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
