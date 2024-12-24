<?php

namespace App\Quizzes\Services;

use App\Questions\Question;
use App\Quizzes\Quiz;

class QuizService
{
    public function create(Question $question, array $requests): Quiz
    {
        $quiz = Quiz::make()
            ->setName($requests['quiz_name'])
            ->setQuestionType($requests['question_type'])
            ->setIsUsedSameScore($requests['is_used_same_score'])
            ->create();

        $quiz->addQuestion($question);

        return $quiz;
    }
}
