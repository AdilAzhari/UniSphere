<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Student;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class StudentEnrollmentChart extends ChartWidget
{
    protected static ?string $heading = 'Student Enrollment Over Time';

    protected function getData(): array
    {
        $data = Trend::model(Student::class)
            ->between(
                start: now()->subYear(),
                end: now(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Students Enrolled',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
