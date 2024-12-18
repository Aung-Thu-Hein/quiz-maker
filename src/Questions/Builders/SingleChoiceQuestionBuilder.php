<?php

namespace App\Questions\Builders;

use App\Questions\SingleChoiceQuestion;

class SingleChoiceQuestionBuilder extends QuestionBuilder
{
    protected string $solution;
    protected array $options;

    public function setOptionsAndSolution(array $options, mixed $solution): self
    {
        $this->options = $options;

        if (!in_array($solution, $this->options)) {
            throw new \InvalidArgumentException("The solution, $solution, must contain in options");
        }
        $this->solution = $solution;

        return $this;
    }

    public function create(): SingleChoiceQuestion
    {
        $question = new SingleChoiceQuestion();
        $question->setBody($this->body);
        $question->setSolution($this->solution);
        $question->setOptions($this->options);
        $question->setScore($this->score);

        return $question;
    }
}
