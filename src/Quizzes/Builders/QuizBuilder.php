<?php

namespace App\Quizzes\Builders;

use App\Questions\Question;
use App\Quizzes\Quiz;

class QuizBuilder extends Quiz
{
    protected string $name;
    protected int $questionType;
    protected Question $question;
    protected bool $isUsedSameScore = false;

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setQuestionType(int $questionType): self
    {
        $this->questionType = $questionType;
        return $this;
    }

    public function setQuestion(Question $question): self
    {
        $this->question = $question;
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
        $quiz->name = $this->name;
        $quiz->questionType = $this->questionType;
        $quiz->questions[] = $this->question;
        $quiz->isUsedSameScore = $this->isUsedSameScore;

        return $quiz;
    }
}
