<?php

namespace App\Enums;

enum AcademicStanding: string
{
    case GOOD = 'good';
    case WARNING = 'warning';
    case PROBATION = 'probation';
    case SUSPENSION = 'suspension';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
