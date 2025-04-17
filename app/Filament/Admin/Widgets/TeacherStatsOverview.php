<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Teacher;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TeacherStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalTeachers = Teacher::count();

        // Number of teachers hired this year
        $newTeachersThisYear = Teacher::whereYear('hire_date', now()->year)->count();

        // Average experience of teachers
        $averageExperience = Teacher::avg('experience');

        // Teachers by department (example: top 3 departments)
        $teachersByDepartment = Teacher::with('department')
            ->selectRaw('department_id, COUNT(*) as count')
            ->groupBy('department_id')
            ->orderByDesc('count')
            ->limit(3)
            ->get();

        $departmentStats = $teachersByDepartment->map(function ($item) {
            return Stat::make($item->department->name, $item->count)
                ->description('Teachers in '.$item->department->name)
                ->color('primary');
        })->toArray();

        return [
            Stat::make('Total Teachers', $totalTeachers)
                ->description('All teachers in the system')
                ->color('success'),

            Stat::make('New Teachers (This Year)', $newTeachersThisYear)
                ->description('Teachers hired this year')
                ->color('warning'),

            Stat::make('Average Experience', round($averageExperience, 1).' years')
                ->description('Average experience of teachers')
                ->color('info'),

            ...$departmentStats, // Add department-specific stats
        ];
    }
}
