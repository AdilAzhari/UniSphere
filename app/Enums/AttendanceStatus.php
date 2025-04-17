<?php

namespace App\Enums;

enum AttendanceStatus: string
{
    case PRESENT = 'Present';
    case ABSENT = 'Absent';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
