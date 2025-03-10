<?php

namespace App\Questions\Services;

use App\Enums\QuestionType;
use App\Questions\Contracts\QuestionDaoInterface;
use App\Questions\Contracts\QuestionServiceInterface;
use App\Questions\Factories\QuestionFactory;
use App\Questions\Question;
use Core\DB;

class QuestionService implements QuestionServiceInterface
{
    protected Question $question;

    public function __construct(protected QuestionDaoInterface $questionDao)
    {
        //
    }

    public function buildQuestion(QuestionType $questionType, array $questions): void
    {
        $question = QuestionFactory::create($questionType);

        $this->question = $question::make()
            ->setBody($questions['body'])
            ->setOptionsAndSolution($questions['options'], $questions['solution'])
            ->setScore($questions['score'])
            ->create();
    }

    public function create(DB $createdQuiz): DB
    {
        return $this->questionDao->create(
            [
                'quiz_id' => $createdQuiz->lastInsertId(),
                'body' => $this->question->getBody(),
                'options' => json_encode($this->question->getOptions()),
                'solution' => json_encode($this->question->getSolution()),
                'score' => $this->question->getScore()
            ]
        );
    }
}
