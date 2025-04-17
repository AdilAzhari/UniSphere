<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case STRIPE = 'Stripe';
    case PAYPAL = 'Paypal';
    case CREDIT_CARD = 'CreditCard';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
