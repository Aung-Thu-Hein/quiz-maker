<?php

namespace App\Quizzes\Controllers;

use App\Enums\QuestionType;
use App\Questions\Contracts\QuestionServiceInterface;
use App\Quizzes\Contracts\QuizServiceInterface;

class QuizController
{
    public function __construct(
        protected QuizServiceInterface $quizService, 
        protected QuestionServiceInterface $questionService
    ) {}

    public function store()
    {
        //Requests from front-end
        $requests = [
            'quiz_name' => "Math Quiz",
            'question_type' => QuestionType::SINGLE_CHOICE,
            'is_used_same_score' => true,
            'questions' => [
                'body' => 'Single choice question 1',
                'options' => ['1', '2', '3', '4', '5'],
                'solution' => '4',
                'score' => 2
            ],
        ];

        $this->quizService->buildQuiz($requests);
        $quiz = $this->quizService->create();

        $this->questionService->buildQuestion($requests['question_type'], $requests['questions']);
        $question = $this->questionService->create($quiz);

        var_dump($quiz);
    }
}
