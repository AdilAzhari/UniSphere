<?php

namespace App\Enums;

enum AnnouncementAudience: string
{
    case GLOBAL = 'Global';
    case WEEK = 'Week';
    case COURSE = 'Course';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
