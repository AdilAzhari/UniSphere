<?php

namespace App\Enums;

enum FileType: string
{
    case VIDEO = 'Video';
    case PDF = 'PDF';
    case ZIP = 'ZIP';
    case PPT = 'PPT';
    case DOC = 'DOC';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
