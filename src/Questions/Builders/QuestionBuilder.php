<?php

namespace App\Questions\Builders;

use App\Questions\Question;

abstract class QuestionBuilder 
{
    protected string $body;
    protected int $score;

    abstract public function setOptionsAndSolution(array $options, mixed $solution): self;
    abstract protected function create(): Question;

    public function setBody(string $body)
    {
        $this->body = $body;
        return $this;
    }

    public function setScore(int $score)
    {
        $this->score = $score;
        return $this;
    }
}
