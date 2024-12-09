<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

use App\Quiz;
use App\Question;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class QuizTest extends TestCase
{

    #[Test]
    public function it_creates_a_quiz_with_one_question_at_least()
    {
        $quiz = new Quiz("Math Quiz", new Question("What is the smallest positive prime number?", "2", 2));

        $this->assertCount(1, $quiz->getQuestions());
    }

    #[Test]
    public function it_consists_of_questions()
    {
        $quiz = new Quiz("Random Quiz", new Question("What is 4-2?", "2", 2));

        $quiz->addQuestion(new Question("What is the largest country in the world?", "Russia", 5));
        $quiz->addQuestion(new Question("In which year, the Covid19 happened?", "2020", 10));

        $this->assertCount(3, $quiz->getQuestions());
    }

    #[Test]
    #[DataProvider('scoreProvider')]
    public function it_calculates_user_score_and_total_score(array $questions, array $answers, int $expectedUserScore, int $expectedTotalScore)
    {
        $quiz = new Quiz("Random Quiz", new Question("What is the smallest positive number?", "0", 5));

        for ($i = 0, $length = count($questions); $i < $length; $i++) {
            $quiz->addQuestion($questions[$i]);
        }

        foreach ($answers as $index => $answer) {
            $quiz->getQuestions()[$index]->setAnswer($answer);
        }

        $userScore = $quiz->calculateUserScore();
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
                    new Question("What is 2+2?", "4", 10),
                    new Question("What symbol is used to declare the variable in PHP?", "$", 20),
                    new Question("What is the first day of a year?", "January 1st", 30),
                ],
                'answers' => ["0", "4", "$", "January 1st"],
                'expectedUserScore' => 65,
                'expectedTotalScore' => 65
            ],

            //Case for half correct
            [
                'questions' => [
                    new Question("What is 2+2?", "4", 1),
                    new Question("What symbol is used to declare the variable in PHP?", "$", 1),
                    new Question("What is the first day of a year?", "January 1st", 1),
                ],
                'answers' => ["1", "4", "var", "January 1st"],
                'expectedUserScore' => 2,
                'expectedTotalScore' => 8
            ],

            //Case for incorrect, score 0
            [
                'questions' => [
                    new Question("What is 2+2?", "4", 20),
                    new Question("What symbol is used to declare the variable in PHP?", "$", 30),
                    new Question("What is the first day of a year?", "January 1st", 40),
                ],
                'answers' => ["9", "40", "var", "June 1st"],
                'expectedUserScore' => 0,
                'expectedTotalScore' => 95
            ]
        ];
    }

    #[Test]
    public function it_uses_same_score_for_all_questions()
    {
        $quiz = new Quiz("Same Score Quiz", new Question("Question-1", "Answer-1", 2), true);

        $quiz->addQuestion(new Question("Question-2", "Answer-2"));
        $quiz->addQuestion(new Question("Questioin-3", "Answer-3"));

        $totalScore = $quiz->calculateTotalScore();

        $this->assertEquals(6, $totalScore);
    }
}
