<?php

namespace Tests\Unit\Questions;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

use App\Questions\SingleChoiceQuestion;

class SingleChoiceQuestionTest extends TestCase
{
    #[Test]
    public function it_creates_a_question()
    {
        $question = SingleChoiceQuestion::make()
            ->setBody("Single choice question 1")
            ->setOptionsAndSolution(['1', '2', '3', '4', '5'], '4')
            ->setScore(2)
            ->create();

        $body = $question->getBody();
        $options = $question->getOptions();
        $solution = $question->getSolution();

        $this->assertNotEmpty($body);
        $this->assertNotEmpty($solution);
        $this->assertNotEmpty($options);
        $this->assertContains($solution, $options);
    }
}
