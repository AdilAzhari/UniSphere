<?php

namespace App\Enums;

enum ProgramProgressStatus: string
{
    case ON_TRACK = 'On Track';
    case PROBATION = 'Probation';
    case AT_RISK = 'At Risk';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
