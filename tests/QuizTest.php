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
    public function it_consists_of_questions()
    {
        $quiz = new Quiz();

        $quiz->addQuestion(new Question("What is 2 + 2?", 4, 100));

        $this->assertCount(1, $quiz->getQuestions());
    }

    #[Test]
    #[DataProvider('scoreProvider')]
    public function it_calculates_user_score_and_total_score(array $questions, array $answers, int $expectedUserScore, int $expectedTotalScore)
    {
        $quiz = new Quiz();

        for($i=0, $length = count($questions); $i<$length; $i++){
            $quiz->addQuestion($questions[$i]);
        }

        foreach($answers as $index => $answer){
            $quiz->getQuestions()[$index]->answer($answer);
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
                    new Question("What is 2+2?", 4, 5),
                    new Question("What is 4+4?", 8, 5),
                    new Question("What is 3+3?", 6, 5),
                ],
                'answers' => [4, 8, 6],
                'expectedUserScore' => 15,
                'expectedTotalScore' => 15
            ],

            //Case for half correct
            [
                'questions' => [
                    new Question("What is 2+2?", 4, 5),
                    new Question("What is 4+4?", 8, 5),
                ],
                'answers' => [4, 1],
                'expectedUserScore' => 5,
                'expectedTotalScore' => 10
            ],

            //Case for incorrect, score 0
            [
                'questions' => [
                    new Question("What is 2+2?", 4, 5),
                    new Question("What is 4+4?", 8, 5),
                    new Question("What is 3+3?", 6, 5),
                ],
                'answers' => [6, 4, 8],
                'expectedUserScore' => 0,
                'expectedTotalScore' => 15
            ]
        ];
    }
}
