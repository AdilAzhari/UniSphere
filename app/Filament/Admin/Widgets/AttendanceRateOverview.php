<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Attendance;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AttendanceRateOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalAttendance = Attendance::count();

        // Present vs Absent records
        $presentCount = Attendance::where('status', 'present')->count();
        $absentCount = Attendance::where('status', 'absent')->count();
        $presentRate = $totalAttendance > 0 ? round(($presentCount / $totalAttendance) * 100, 2) : 0;
        $absentRate = $totalAttendance > 0 ? round(($absentCount / $totalAttendance) * 100, 2) : 0;

        // Attendance by teacher (example: top 3 teachers)
        $attendanceByTeacher = Attendance::with('teacher.user')
            ->selectRaw('teacher_id, COUNT(*) as count')
            ->groupBy('teacher_id')
            ->orderByDesc('count')
            ->limit(3)
            ->get();

        $teacherStats = $attendanceByTeacher->map(function ($item) {
            return Stat::make($item->teacher->user->name, $item->count)
                ->description('Attendance records for '.$item->teacher->user->name)
                ->color('primary');
        })->toArray();

        return [
            Stat::make('Total Attendance Records', $totalAttendance)
                ->description('All attendance records in the system')
                ->color('success'),

            Stat::make('Present Rate', $presentRate.'%')
                ->description('Percentage of present records')
                ->color('success'),

            Stat::make('Absent Rate', $absentRate.'%')
                ->description('Percentage of absent records')
                ->color('danger'),

            ...$teacherStats, // Add teacher-specific stats
        ];
    }
}
