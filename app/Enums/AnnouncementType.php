<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum AnnouncementType: string implements HasLabel
{
    case ANNOUNCEMENT = 'Announcement';
    case ASSESSMENT = 'Assessment';
    case QUIZ = 'Quiz';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ANNOUNCEMENT => __('Announcement'),
            self::ASSESSMENT => __('Assessment'),
            self::QUIZ => __('Quiz'),
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
