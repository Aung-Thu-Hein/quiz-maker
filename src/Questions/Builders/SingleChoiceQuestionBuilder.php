<?php

namespace App\Questions\Builders;

use App\Questions\SingleChoiceQuestion;

class SingleChoiceQuestionBuilder extends SingleChoiceQuestion
{
    protected string $body;
    protected string $solution;
    protected array $options;
    protected int $score;

    public function setBody(string $body): self
    {
        $this->body = $body;
        return $this;
    }

    public function setOptionsAndSolution(array $options, string $solution): self
    {
        $this->options = $options;

        if (!in_array($solution, $this->options)) {
            throw new \InvalidArgumentException("The solution, $solution, must contain in options");
        }
        $this->solution = $solution;

        return $this;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;
        return $this;
    }

    public function create(): SingleChoiceQuestion
    {
        $question = new SingleChoiceQuestion();
        $question->body = $this->body;
        $question->solution = $this->solution;
        $question->options = $this->options;
        $question->score = $this->score;

        return $question;
    }
}
