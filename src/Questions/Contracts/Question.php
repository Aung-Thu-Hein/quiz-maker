<?php

namespace App\Questions\Contracts;

interface Question
{
    public function checkAnswer(mixed $answer): bool;
}
