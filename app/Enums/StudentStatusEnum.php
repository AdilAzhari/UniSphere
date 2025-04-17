<?php

namespace App\Enums;

enum StudentStatusEnum: string
{
    case ACTIVE = 'Active';
    case GRADUATED = 'Graduated';
    case WITHDRAWN = 'Withdrawn';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
