<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ProctorStatus: string implements HasLabel
{
    case PENDING = 'Pending';
    case APPROVED = 'Approved';
    case REJECTED = 'Rejected';

    /**
     * Get all the values of the enum.
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PENDING => __('Proctor.Pending'),
            self::APPROVED => __('Proctor.Approved'),
            self::REJECTED => __('Proctor.Rejected'),
        };
    }
}
