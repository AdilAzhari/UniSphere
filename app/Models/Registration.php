<?php

namespace App\Models;

use Filament\Forms\Components\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Registration extends Model
{
    use HasFactory, softdeletes;

    protected $fillable = [
        'student_id',
        'course_id',
        'proctor_id',
        'term_id',
        'registration_status',
        'proctor_approval_status',
        'proctored',
        'payment_status',
        'registered_at',
        'completion_date',
    ];

    protected Hidden $status;

    protected $casts = [
        'registered_at' => 'date',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function proctor(): BelongsTo
    {
        return $this->belongsTo(Proctor::class);
    }

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

    public function scopeInProgress($query)
    {
        return $query->where('registration_status', 'in_progress');
    }

    public function scopePastCourses($query)
    {
        return $query->where('registration_status', 'completed');
    }

    public function scopeFutureCourses($query)
    {
        return $query->where('registration_status', 'registered');
    }

    public function scopeCurrentCourses($query)
    {
        return $query->where('registration_status', 'in_progress');
    }

    public function scopeAvailableCourses($query)
    {
        return $query->where('registration_status', 'registered');
    }

    public function scopeProctored($query): void
    {
        $query->where('proctored', true);
    }
}
