<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum QuizStatus: string implements HasLabel
{
    case DRAFT = 'Draft';
    case PUBLISHED = 'Published';
    case Closed = 'Closed';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::PUBLISHED => 'Published',
            self::Closed => 'Closed',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
