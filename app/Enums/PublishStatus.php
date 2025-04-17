<?php

namespace App\Enums;

enum PublishStatus: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
