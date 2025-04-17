<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum AttendanceReason: string implements HasLabel
{
    case SICK = 'Sick';
    case VACATION = 'Vacation';
    case OTHER = 'Other';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::OTHER => __('Other'),
            self::SICK => __('Sick'),
            self::VACATION => __('Vacation'),
        };
    }
}
