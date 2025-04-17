<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum QuizDuration: string implements HasLabel
{
    case TEN = '10';
    case TWENTY = '20';
    case THIRTY = '30';
    case FORTY_FIVE = '45';
    case SIXTY = '60';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::TEN => '10 minutes',
            self::TWENTY => '20 minutes',
            self::THIRTY => '30 minutes',
            self::FORTY_FIVE => '45 minutes',
            self::SIXTY => '60 minutes',
        };
    }
}
