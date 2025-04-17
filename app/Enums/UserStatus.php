<?php

namespace App\Enums;

enum UserStatus: string
{
    case ACTIVE = 'Active';
    case INACTIVE = 'Inactive';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
