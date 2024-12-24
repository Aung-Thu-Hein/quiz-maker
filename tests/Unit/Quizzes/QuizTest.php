<?php

namespace Tests\Unit\Quizzes;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

use App\Questions\Question;
use App\Questions\MultipleChoiceQuestion;
use App\Questions\SingleChoiceQuestion;
use App\Quizzes\Quiz;
use App\Enums\QuestionType;

class QuizTest extends TestCase
{
    private Question $singleChoiceQues;
    private Quiz $quiz;

    protected function setUp(): void
    {
        $questionType = QuestionType::SINGLE_CHOICE->value;
        $question = match ($questionType) {
            QuestionType::SINGLE_CHOICE->value => new SingleChoiceQuestion(),
            QuestionType::MULTIPLE_CHOICE->value => new MultipleChoiceQuestion()
        };

        $this->singleChoiceQues = $question::make()
            ->setBody("Single choice question 1")
            ->setOptionsAndSolution(['1', '2', '3', '4', '5'], '4')
            ->setScore(2)
            ->create();

        $this->quiz = Quiz::make()
            ->setName("Math Quiz")
            ->setQuestionType($questionType)
            ->setIsUsedSameScore(true)
            ->create();

        $this->quiz->addQuestion($this->singleChoiceQues);
    }

    #[Test]
    public function it_creates_a_quiz_with_one_question_at_least()
    {
        $this->assertCount(1, $this->quiz->getQuestions());
    }

    #[Test]
    public function it_consists_of_questions()
    {
        for ($i = 2; $i < 4; $i++) {
            $question = SingleChoiceQuestion::make()
                ->setBody("Single choice question $i")
                ->setOptionsAndSolution(['1', '2', '3', '4', '5'], '4')
                ->setScore(2)
                ->create();

            $this->quiz->addQuestion($question);
        }

        $this->assertCount(3, $this->quiz->getQuestions());
    }

    #[Test]
    #[DataProvider('scoreProvider')]
    public function it_calculates_user_score_and_total_score(array $questions, array $answers, int $expectedUserScore, int $expectedTotalScore)
    {
        $questionType = QuestionType::SINGLE_CHOICE->value;
        $quiz = Quiz::make()
            ->setName("Math Quiz")
            ->setQuestionType($questionType)
            ->setIsUsedSameScore(false)
            ->create();

        for ($i = 0, $length = count($questions); $i < $length; $i++) {
            $quiz->addQuestion($questions[$i]);
        }

        $userScore = 0;
        foreach ($answers as $index => $answer) {
            $quiz->getQuestions()[$index]->checkAnswer($answer) ?
                $userScore += $quiz->getQuestions()[$index]->getScore() : $userScore;
        }
        $this->assertEquals($expectedUserScore, $userScore);

        $totalScore = $quiz->calculateTotalScore();
        $this->assertEquals($expectedTotalScore, $totalScore);
    }

    public static function scoreProvider()
    {
        return [
            //Case for all correct
            [
                'questions' => [
                    SingleChoiceQuestion::make()->setBody("What is 2+2?")->setOptionsAndSolution(['1', '2', '4'], '4')->setScore(10)->create(),
                    SingleChoiceQuestion::make()->setBody("What symbol is used to declare the variable in PHP?")->setOptionsAndSolution(['let', 'var', '$'], '$')->setScore(20)->create(),
                    SingleChoiceQuestion::make()->setBody("What is the first day of a year?")->setOptionsAndSolution(['January 1st', 'June 1st', '1/1/1000'], 'January 1st')->setScore(30)->create(),
                ],
                'answers' => ["4", "$", "January 1st"],
                'expectedUserScore' => 60,
                'expectedTotalScore' => 60
            ],

            //Case for half correct
            [
                'questions' => [
                    SingleChoiceQuestion::make()->setBody("What is -2+2?")->setOptionsAndSolution(['0', '-2', '-4'], '0')->setScore(1)->create(),
                    SingleChoiceQuestion::make()->setBody("What is 2+2?")->setOptionsAndSolution(['1', '2', '4'], '4')->setScore(1)->create(),
                    SingleChoiceQuestion::make()->setBody("What symbol is used to declare the variable in PHP?")->setOptionsAndSolution(['let', 'var', '$'], '$')->setScore(1)->create(),
                    SingleChoiceQuestion::make()->setBody("What is the first day of a year?")->setOptionsAndSolution(['January 1st', 'June 1st', '1/1/1000'], 'January 1st')->setScore(1)->create(),
                ],
                'answers' => ["-2", "4", "var", "January 1st"],
                'expectedUserScore' => 2,
                'expectedTotalScore' => 4
            ],

            //Case for incorrect, score 0
            [
                'questions' => [
                    SingleChoiceQuestion::make()->setBody("What is 2+2?")->setOptionsAndSolution(['1', '2', '4'], '4')->setScore(20)->create(),
                    SingleChoiceQuestion::make()->setBody("What symbol is used to declare the variable in PHP?")->setOptionsAndSolution(['let', 'var', '$'], '$')->setScore(30)->create(),
                    SingleChoiceQuestion::make()->setBody("What is the first day of a year?")->setOptionsAndSolution(['January 1st', 'June 1st', '1/1/1000'], 'January 1st')->setScore(40)->create(),
                ],
                'answers' => ["1", "var", "June 1st"],
                'expectedUserScore' => 0,
                'expectedTotalScore' => 90
            ]
        ];
    }

    #[Test]
    public function it_uses_same_score_for_all_questions()
    {
        for ($i = 2; $i < 4; $i++) {
            $question = SingleChoiceQuestion::make()
                ->setBody("Single choice question $i")
                ->setOptionsAndSolution(['1', '2', '3', '4', '5'], '4')
                ->setScore(2)
                ->create();

            $this->quiz->addQuestion($question);
        }

        $totalScore = $this->quiz->calculateTotalScore();
        $this->assertEquals(6, $totalScore);
    }
}
