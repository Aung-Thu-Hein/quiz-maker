<?php

namespace App\Questions\Builders;

use App\Questions\MultipleChoiceQuestion;

class MultipleChoiceQuestionBuilder extends QuestionBuilder
{
    protected array $options;
    protected array $solutions;

    public function setOptionsAndSolution(array $options, mixed $solutions): self
    {
        $this->options = $options;

        if (!empty(array_diff($solutions, $this->options))) {
            throw new \InvalidArgumentException("All the solutions must contaion in options");
        }

        $this->solutions = $solutions;
        return $this;
    }

    public function create(): MultipleChoiceQuestion
    {
        $question = new MultipleChoiceQuestion();
        $question->setBody($this->body);
        $question->setSolution($this->solutions);
        $question->setOptions($this->options);
        $question->setScore($this->score);

        return $question;
    }
}
