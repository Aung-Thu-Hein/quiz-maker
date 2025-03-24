<?php

namespace App\Quizzes\Controllers;

use App\Questions\Contracts\QuestionServiceInterface;
use App\Quizzes\Contracts\QuizServiceInterface;
use App\Traits\ApiResponse;
use Core\Http\Request;

class QuizController
{
    use ApiResponse;

    public function __construct(
        protected QuizServiceInterface $quizService, 
        protected QuestionServiceInterface $questionService
    ) {}

    public function index()
    {
        $quizzes = $this->quizService->getAllQuizzes();

        $this->response(200, data: $quizzes);
    }

    public function store(Request $request)
    {
        $this->quizService->buildQuiz($request);
        $quiz = $this->quizService->createQuiz();

        $this->questionService->buildQuestion($request);
        $question = $this->questionService->createQuestion($quiz);

        $data = [
            'name' => $quiz->getName(),
            'isUsedSameScore' => $quiz->getIsUsedSameScore(),
            'question' => [
                'score' => $question->getScore()
            ]
        ];

        $this->response(201, data: $data);
    }

    public function show(int $id)
    {
        $quiz = $this->quizService->getQuiz($id);
        
        if(!$quiz) {
            $this->response(404);
        }

        $this->response(200, data: $quiz);
    }

    public function update(int $id, Request $request)
    {
        $isUpdated = $this->quizService->updateQuiz($id, $request);

        if(!$isUpdated) {
            $this->response(400);
        }

        $this->response(200, 'Successfully updated the quiz');
    }

    public function delete(int $id)
    {
        $isDeleted = $this->quizService->deleteQuiz($id);

        if(!$isDeleted) {
            $this->response(400);
        }

        $this->response(200, 'Successfully deleted the quiz');
    }
}
