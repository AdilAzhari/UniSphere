<?php

namespace App\Enums;

enum ContentType: string
{
    case LECTURE = 'lecture';
    case ASSIGNMENT = 'assignment';
    case RESOURCE = 'resource';
    case QUIZ = 'quiz';
    case DISCUSSION = 'discussion';
    case SYLLABUS = 'syllabus';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
