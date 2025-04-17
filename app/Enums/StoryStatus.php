<?php

namespace App\Enums;

enum StoryStatus: string
{
    case DRAFT = 'Draft';
    case PUBLISHED = 'Published';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
