<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum QuizType: string implements HasLabel
{
    case GRADED = 'Graded';
    case UNGRADED = 'Ungraded';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::GRADED => __('Graded'),
            self::UNGRADED => __('Ungraded'),
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
