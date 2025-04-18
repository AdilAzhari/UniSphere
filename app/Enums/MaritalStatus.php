<?php

namespace App\Enums;

enum MaritalStatus: string
{
    case SINGLE = 'Single';
    case MARRIED = 'Married';
    case DIVORCED = 'Divorced';
    case WIDOWED = 'Widowed';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
