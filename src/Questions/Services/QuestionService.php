<?php

namespace App\Questions\Services;

use App\Enums\QuestionType;
use App\Questions\Contracts\QuestionDaoInterface;
use App\Questions\Contracts\QuestionServiceInterface;
use App\Questions\Factories\QuestionFactory;
use App\Questions\Question;
use App\Quizzes\Contracts\QuizDaoInterface;
use Core\Http\Request;

class QuestionService implements QuestionServiceInterface
{
    protected Question $question;

    public function __construct(
        protected QuestionDaoInterface $questionDao, 
        protected QuizDaoInterface $quizDao
    )
    {
        //
    }

    public function buildQuestion(Request $request): void
    {
        $attributes = $request->getAttributes();
        $question = QuestionFactory::create(QuestionType::from($attributes['questionType']));

        $this->question = $question::make()
            ->setBody($attributes['question']['body'])
            ->setOptionsAndSolution($attributes['question']['options'], $attributes['question']['solution'])
            ->setScore($attributes['question']['score'])
            ->create();
    }

    public function getQuestion(int $id, int $quiz_id): false|array
    {
        $question = $this->questionDao->show($id, $quiz_id);

        if(!$question) {
            return false;
        }

        $question['options'] = json_decode($question['options'], true);
        $question['solution'] = json_decode($question['solution'], true);

        return $question;
    }

    public function createQuestion(int $quiz_id): Question
    {
        $this->questionDao->create(
            [
                'quiz_id' => $quiz_id,
                'body' => $this->question->getBody(),
                'options' => json_encode($this->question->getOptions()),
                'solution' => json_encode($this->question->getSolution()),
                'score' => $this->question->getScore()
            ]
        );

        return $this->question;
    }

    public function createQuestions(int $quiz_id, Request $request): bool
    {
        $questions = $request->getAttributes()['questions'];

        $data = [];
        foreach($questions as $question) {
            array_push($data, [
                'body' => $question['body'],
                'options' => json_encode($question['options'], true),
                'solution' => json_encode($question['solution'], true),
                'score' => $question['score']
            ]);
        }

        $question = $this->questionDao->createMultiple($quiz_id, $data);
        
        if(!$question->lastInsertId()) {
            return false;
        }

        return true;
    }

    public function updateQuestion(int $id, int $quiz_id, Request $request): int|false
    {
        $question = $this->questionDao->show($id, $quiz_id);

        if(!$question) {
            return false;
        }

        $attributes = $request->getAttributes();

        $data = [
            'body' => $attributes['body'],
            'options' => json_encode($attributes['options'], true),
            'solution' => json_encode($attributes['solution'], true),
            'score' => $attributes['score']
        ];

        $this->questionDao->update($id, $quiz_id, $data);

        return $question['id'];
    }

    public function deleteQuestion(int $id, int $quiz_id): bool
    {
        $question = $this->questionDao->show($id, $quiz_id);

        if(!$question) {
            return false;
        }

        $isDeleted = $this->questionDao->delete($id, $quiz_id);
        return $isDeleted;
    }
}