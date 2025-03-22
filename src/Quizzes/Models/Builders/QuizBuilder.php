<?php

namespace App\Quizzes\Models\Builders;

use App\Enums\QuestionType;
use App\Quizzes\Models\Quiz;

class QuizBuilder extends Quiz
{
    protected ?int $id = null;
    protected string $name;
    protected QuestionType $questionType;
    protected bool $isUsedSameScore = false;

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setQuestionType(QuestionType $questionType): self
    {
        $this->questionType = $questionType;
        return $this;
    }

    public function setIsUsedSameScore(bool $isUsedSameScore): self
    {
        $this->isUsedSameScore = $isUsedSameScore;
        return $this;
    }

    public function create(): Quiz
    {
        $quiz = new Quiz();
        $quiz->id = $this->id;
        $quiz->name = $this->name;
        $quiz->questionType = $this->questionType;
        $quiz->isUsedSameScore = $this->isUsedSameScore;

        return $quiz;
    }
}
