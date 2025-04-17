<?php

namespace App\Models;

use App\Enums\ProctorStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enrollment extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'course_id',
        'term_id',
        'proctored',
        'status',
        'enrollment_date',
        'proctor_status',
        'completion_date',
        'grade_points',
        'grade',
    ];

    protected $attributes = [
        'grade_points' => 0.00,
        'grade' => 0,
        'proctored' => false,
    ];

    protected $casts = [
        'enrollment_date' => 'datetime',
        'completion_date' => 'datetime',
        'proctor_status' => ProctorStatus::class,
        'proctored' => 'bool',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(registration::class);
    }

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'Enrolled');
    }

    public function scopePastEnrollments($query)
    {
        return $query->whereDate('enrollment_date', '<', now());
    }
}
