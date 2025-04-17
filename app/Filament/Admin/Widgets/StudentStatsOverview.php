<?php

namespace App\Filament\Admin\Widgets;

use App\Enums\StudentStatus;
use App\Models\Student;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StudentStatsOverview extends BaseWidget
{
    //    protected static string $view = 'filament.widgets.student-stats-overview';
    protected function getStats(): array
    {
        $totalStudents = Student::count();

        // Number of enrolled students
        $enrolledStudents = Student::where('status', StudentStatus::ENROLLED)->count();

        // Number of graduated students
        $graduatedStudents = Student::where('status', StudentStatus::GRADUATED)->count();

        return [
            Stat::make('Total Students', $totalStudents)
                ->description('All students in the system')
                ->color('primary'),

            Stat::make('Enrolled Students', $enrolledStudents)
                ->description('Currently enrolled students')
                ->color('success'),

            Stat::make('Graduated Students', $graduatedStudents)
                ->description('Students who have graduated')
                ->color('warning'),
        ];
    }
}
