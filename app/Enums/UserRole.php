<?php

namespace App\Enums;

enum UserRole: string
{
    case STUDENT = 'Student';
    case ADMIN = 'Admin';
    case TEACHER = 'Teacher';
    case TECHNICAL_TEAM = 'Technical_Team';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
