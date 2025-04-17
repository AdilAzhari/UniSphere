<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ExamStatus: string implements HasLabel
{
    case PASSED = 'Passed';
    case FAILED = 'Failed';
    case ABSENT = 'Absent';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PASSED => __('Passed'),
            self::FAILED => __('Failed'),
            self::ABSENT => __('Absent'),
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
