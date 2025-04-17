<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum CoursePayment: string implements HasLabel
{
    case PAID = 'Paid';
    case UNPAID = 'Unpaid';
    case FUTURE = 'FuturePayment';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PAID => __('Paid'),
            self::UNPAID => __('Unpaid'),
            self::FUTURE => __('FuturePayment'),
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
