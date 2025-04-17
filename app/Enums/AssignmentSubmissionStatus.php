<?php

namespace App\Enums;

enum AssignmentSubmissionStatus: string
{
    case PENDING = 'Pending';
    case SUBMITTED = 'Submitted';
    case GRADED = 'Graded';
    case LATE_SUBMISSION = 'LateSubmission';
    case PREVIEW = 'RnReview';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
