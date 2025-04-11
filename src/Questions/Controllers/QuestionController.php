<?php

namespace App\Questions\Controllers;

use App\Questions\Contracts\QuestionServiceInterface;
use App\Traits\ApiResponse;
use Core\Http\Request;

class QuestionController
{
    use ApiResponse;

    public function __construct(public QuestionServiceInterface $questionService)
    {
        //
    }

    public function show(int $id, int $quiz_id)
    {
        $question = $this->questionService->getQuestion($id, $quiz_id);

        if(!$question) {
            $this->response(404);
        }

        $this->response(200, data: $question);
    }

    public function store(Request $request, int $quiz_id)
    {
        $isCreated = $this->questionService->createQuestions($quiz_id, $request);

        if(!$isCreated) {
            $this->response(400, message: 'Something is wrong!');
        }

        $this->response(201);
    }

    public function update(int $id, int $quiz_id, Request $request)
    {
        $questionId = $this->questionService->updateQuestion($id, $quiz_id, $request);

        if(!$questionId) {
            $this->response(404);
        }

        $this->response(200, 'Successfully updated a question');
    }

    public function delete(int $id, int $quiz_id)
    {
        $isDeleted = $this->questionService->deleteQuestion($id, $quiz_id);

        if(!$isDeleted){
            $this->response(400, 'Failed to delete!');
        }

        $this->response(200, 'Successfully deleted the question');
    }
}
