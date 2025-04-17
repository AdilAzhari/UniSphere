<?php

namespace App\Models;

use App\Enums\AttendanceReason;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * These fields can be filled when creating or updating the model.
     */
    protected $fillable = [
        'enrollment_id',
        'class_group_id',
        'student_id',
        'teacher_id',
        'date',
        'status',
        'reason',
        'notes',
    ];

    /**
     * Default attribute values for newly created attendance records.
     */
    protected $attributes = [
        'status' => 'present', // Default status is "present"
        'reason' => AttendanceReason::SICK, // Default reason is "sick" (from the AttendanceReason enum)
    ];

    /**
     * Attribute casting to ensure correct data types.
     */
    protected $casts = [
        'date' => 'datetime', // Converts 'date' field into a DateTime object
        'reason' => AttendanceReason::class, // Casts 'reason' field to the AttendanceReason enum
    ];

    /**
     * Get the enrollment associated with this attendance record.
     */
    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    /**
     * Get the class group associated with this attendance record.
     */
    public function classGroup(): BelongsTo
    {
        return $this->belongsTo(ClassGroup::class);
    }

    /**
     * Get the student associated with this attendance record.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the teacher who marked this attendance record.
     * belongs To
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }
}
