<?php

namespace App\Enums;

enum PaymentTransactionType: string
{
    case EXAM_COURSE_PROCESSING_FEE = 'Exam/Course Processing Fee';
    case TRANSFERRING_CREDIT_FEE = 'Transferring Credit Fee';
    case APPLICATION_FEE = 'application Fee';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
