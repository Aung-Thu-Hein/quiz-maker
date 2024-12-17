<?php

namespace App\Questions\Builders;

use App\Questions\MultipleChoiceQuestion;

class MultipleChoiceQuestionBuilder extends MultipleChoiceQuestion
{
    protected string $body;
    protected array $options;
    protected array $solutions;
    protected int $score;

    public function setBody(string $body): self
    {
        $this->body = $body;
        return $this;
    }

    public function setOptionsAndSolutions(array $options, array $solutions): self
    {
        $this->options = $options;

        if (!empty(array_diff($solutions, $this->options))) {
            throw new \InvalidArgumentException("All the solutions must contaion in options");
        }

        $this->solutions = $solutions;
        return $this;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;
        return $this;
    }

    public function create(): MultipleChoiceQuestion
    {
        $question = new MultipleChoiceQuestion();
        $question->body = $this->body;
        $question->solutions = $this->solutions;
        $question->options = $this->options;
        $question->score = $this->score;

        return $question;
    }
}
