<?php

namespace App\Quizzes\Controllers;

use App\Enums\QuestionType;
use App\Questions\Services\QuestionService;
use App\Quizzes\Services\QuizService;

class QuizController
{
    public function __construct(
        protected QuizService $quizService, 
        protected QuestionService $questionService
    ) {}

    public function store()
    {
        //Requests from front-end
        $requests = [
            'quiz_name' => "Math Quiz",
            'question_type' => QuestionType::SINGLE_CHOICE->value,
            'questions' => [
                'body' => 'Single choice question 1',
                'options' => ['1', '2', '3', '4', '5'],
                'solution' => '4',
                'score' => 2
            ],
            'is_used_same_score' => true,
        ];

        $question = $this->questionService->create($requests['question_type'], $requests['questions']);

        $quiz = $this->quizService->create($question, $requests);

        var_dump($quiz);
    }
}
