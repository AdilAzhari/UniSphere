<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum TeacherStatus: string implements HasLabel
{
    case ACTIVE = 'Active';
    case INACTIVE = 'Inactive';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ACTIVE => __('Active'),
            self::INACTIVE => __('Inactive'),
        };
    }
}
