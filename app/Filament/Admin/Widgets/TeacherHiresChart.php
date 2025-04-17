<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Teacher;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class TeacherHiresChart extends ChartWidget
{
    protected static ?string $heading = 'Teacher Hires Over Time';

    protected function getData(): array
    {
        $data = Trend::model(Teacher::class)
            ->between(now()->subYear(), now())
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Teachers Hired',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'bubble';
    }
}
