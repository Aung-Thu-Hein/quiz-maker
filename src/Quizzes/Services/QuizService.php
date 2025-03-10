<?php

namespace App\Quizzes\Services;

use App\Quizzes\Quiz;
use App\Quizzes\Contracts\QuizDaoInterface;
use App\Quizzes\Contracts\QuizServiceInterface;
use App\Questions\Contracts\QuestionDaoInterface;
use Core\DB;

class QuizService implements QuizServiceInterface
{
    protected Quiz $quiz;

    public function __construct(
        protected QuizDaoInterface $quizDao, 
        protected QuestionDaoInterface $questionDao
    ) {}

    public function buildQuiz(array $requests)
    {
        $this->quiz = Quiz::make()
            ->setName($requests['quiz_name'])
            ->setQuestionType($requests['question_type'])
            ->setIsUsedSameScore($requests['is_used_same_score'])
            ->create();
    }

    public function create(): DB
    {
        return $this->quizDao->create(
            [
                'name' => $this->quiz->getName(), 
                'is_used_same_score' => $this->quiz->getIsUsedSameScore(), 
                'question_type' => $this->quiz->getQuestionType()->value
            ]
        );
    }
}
