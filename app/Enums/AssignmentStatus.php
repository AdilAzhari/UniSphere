<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum AssignmentStatus: string implements HasLabel
{
    case PENDING = 'Pending';
    case COMPLETED = 'Completed';
    case OVERDUE = 'Overdue';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PENDING => __('Pending'),
            self::COMPLETED => __('Completed'),
            self::OVERDUE => __('Overdue'),
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
