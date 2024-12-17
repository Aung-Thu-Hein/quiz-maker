<?php

namespace Tests\Unit\Questions;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

use App\Questions\MultipleChoiceQuestion;

class MultipleChoiceQuestionTest extends TestCase
{
    #[Test]
    public function it_creates_a_question()
    {
        $question = MultipleChoiceQuestion::make()
            ->setBody("Multiple choice question 1")
            ->setOptionsAndSolutions(['1', '2', '3', '4', '5'], ['2', '4'])
            ->setScore(2)
            ->create();

        $body = $question->getBody();
        $options = $question->getOptions();
        $solutions = $question->getSolutions();

        $this->assertNotEmpty($body);
        $this->assertNotEmpty($solutions);
        $this->assertNotEmpty($options);

        foreach ($solutions as $solution) {
            $this->assertContains($solution, $options);
        }
    }
}
