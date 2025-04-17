<?php

namespace App\Enums;

enum SubmissionStatus: string
{
    case PENDING = 'Pending';
    case SUBMITTED = 'Submitted';
    case GRADED = 'Graded';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
