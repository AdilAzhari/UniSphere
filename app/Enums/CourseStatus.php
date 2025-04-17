<?php

namespace App\Enums;

enum CourseStatus: string
{
    case COMPLETED = 'completed';
    case IN_PROGRESS = 'in_progress';
    case NOT_STARTED = 'not_started';
    case WITHDRAWN = 'withdrawn';
    case FAILED = 'failed';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
