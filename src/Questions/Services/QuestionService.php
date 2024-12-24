<?php

namespace App\Questions\Services;

use App\Questions\Factories\QuestionFactory;
use App\Questions\Question;

class QuestionService
{
    public function create(int $questionType, array $questions): Question
    {
        $question = QuestionFactory::create($questionType);

        return $question::make()
            ->setBody($questions['body'])
            ->setOptionsAndSolution($questions['options'], $questions['solution'])
            ->setScore($questions['score'])
            ->create();
    }
}
