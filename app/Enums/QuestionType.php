<?php

namespace App\Enums;

enum QuestionType: string
{
    case TRUE_FALSE = 'true_false';
    case MULTIPLE_CHOICE = 'multiple_choice';
    case OPEN_ENDED = 'open_ended';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
