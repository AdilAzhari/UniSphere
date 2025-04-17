<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case PENDING = 'Pending';
    case COMPLETED = 'Completed';
    case FAILED = 'Failed';
    case REFUNDED = 'Refunded';
    case CANCELLED = 'Cancelled';
    case UNPAID = 'unpaid';
    case PAID = 'paid';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
