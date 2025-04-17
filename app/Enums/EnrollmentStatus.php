<?php

namespace App\Enums;

enum EnrollmentStatus: string
{
    case ENROLLED = 'Enrolled';
    case PENDING = 'Pending';
    case COMPLETED = 'Completed';
    case DROPPED = 'Dropped';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
