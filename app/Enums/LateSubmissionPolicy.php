<?php

namespace App\Enums;

enum LateSubmissionPolicy: string
{
    case NOT_ALLOWED = 'NotAllowed';
    case ALLOWED = 'Allowed';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
