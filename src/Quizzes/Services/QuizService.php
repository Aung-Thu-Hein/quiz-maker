<?php

namespace App\Quizzes\Services;

use Core\Http\Request;
use App\Enums\QuestionType;
use App\Quizzes\Models\Quiz;
use App\Quizzes\Contracts\QuizDaoInterface;
use App\Quizzes\Contracts\QuizServiceInterface;
use App\Questions\Contracts\QuestionDaoInterface;

class QuizService implements QuizServiceInterface
{
    protected Quiz $quiz;

    public function __construct(
        protected QuizDaoInterface $quizDao, 
        protected QuestionDaoInterface $questionDao
    ) {}

    public function buildQuiz(Request $request)
    {
        $attributes = $request->getAttributes();

        $this->quiz = Quiz::make()
            ->setId($attributes['id'] ?? null)
            ->setName($attributes['name'])
            ->setQuestionType(QuestionType::from($attributes['questionType']))
            ->setIsUsedSameScore($attributes['isUsedSameScore'])
            ->create();
    }

    public function getAllQuizzes(): array
    {
        $quizzes = $this->quizDao->all();

        return array_map(fn($quiz) => $this->map($quiz), $quizzes);
    }

    public function createQuiz(): Quiz
    {
        $createdQuiz = $this->quizDao->create(
            [
                'name' => $this->quiz->getName(), 
                'is_used_same_score' => (int) $this->quiz->getIsUsedSameScore(), 
                'question_type' => $this->quiz->getQuestionType()->value
            ]
        );

        $this->quiz->setId($createdQuiz->lastInsertId());
        return $this->quiz;
    }

    public function getQuiz(int $id): array|false
    {
        $quiz = $this->quizDao->show($id);

        if(!$quiz) {
            return false;
        }

        return $this->map($quiz);
    }

    public function updateQuiz(int $id, Request $request): int|false
    {
        $quiz = $this->quizDao->show($id);

        if(!$quiz) {
            return false;
        }

        $attributes = $request->getAttributes();

        $this->quizDao->update($quiz['id'], [
            'name' => $attributes['name'], 
            'is_used_same_score' => (int) $attributes['isUsedSameScore'], 
            'question_type' => $attributes['questionType']
        ]);

        return $quiz['id'];
    }

    public function deleteQuiz(int $id): int|false 
    {
        $quiz = $this->quizDao->show($id);

        if(!$quiz) {
            return false;
        }

        $this->quizDao->delete($id);

        return $quiz['id'];
    }

    public function map(array $quiz)
    {
        return [
            'id' => $quiz['id'],
            'name' => $quiz['name'],
            'isUsedSameScore' => (bool) $quiz['is_used_same_score'],
            'questionType' => QuestionType::getLabel($quiz['question_type']),
            'createdAt' => $quiz['created_at'],
            'updatedAt' => $quiz['updated_at']
        ];
    }
}
