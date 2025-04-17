<?php

namespace App\Enums;

enum ExamResultStatus: string
{
    case PASSED = 'Passed';
    case FAILED = 'Failed';
    case ABSENT = 'Absent';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
