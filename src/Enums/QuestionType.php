<?php

namespace App\Enums;

enum QuestionType: int
{
    case SINGLE_CHOICE = 1;
    case MULTIPLE_CHOICE = 2;

    public static function getLabel(int $value): string
    {
        return match($value) {
            self::SINGLE_CHOICE->value => 'Single Choice',
            self::MULTIPLE_CHOICE->value => 'Multiple Choice',
            default => throw new \InvalidArgumentException("Invalid question type value...")
        };
    }
}
