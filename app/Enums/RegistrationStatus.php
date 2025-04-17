<?php

namespace App\Enums;

enum RegistrationStatus: string
{
    case REGISTERED = 'registered';
    case IN_PROGRESS = 'in_progress';

    case COMPLETED = 'completed';
    case WITHDRAWN = 'withdrawn';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
