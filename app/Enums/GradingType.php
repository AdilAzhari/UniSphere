<?php

namespace App\Enums;

enum GradingType: string
{
    case NUMERIC = 'Numeric';
    case LETTER = 'Letter';
    case PASS_FAIL = 'PassFail';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
