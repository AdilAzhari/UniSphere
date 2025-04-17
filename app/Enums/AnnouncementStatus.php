<?php

namespace App\Enums;

enum AnnouncementStatus: string
{
    case INACTIVE = 'InActive';
    case ACTIVE = 'Active';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
