<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Course extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * These fields can be filled using mass assignment.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'code',
        'credit_hours',
        'description',
        'syllabus',
        'image',
        'max_students',
        'status',
        'require_proctor',
        'paid',
        'prerequisite_course_id',
        'course_category_id',
        'cost',
        'teacher_id',
        'program_id',
        'proctor_id',
        'department_id',
        'sequence',
        'term_id',
    ];

    /**
     * bel
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function classes(): HasMany
    {
        return $this->hasMany(ClassGroup::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class);
    }

    public function materials(): HasMany
    {
        return $this->hasMany(Material::class);
    }

    public function exam(): HasOne
    {
        return $this->hasOne(Exam::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function proctor(): BelongsTo
    {
        return $this->belongsTo(Proctor::class);
    }

    public function weeks(): HasMany
    {
        return $this->hasMany(Week::class);
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function enrollment(): HasOne
    {
        return $this->hasOne(Enrollment::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function courseRequirements(): HasMany
    {
        return $this->hasMany(CourseRequirement::class);
    }

    public function studentCourses(): HasMany
    {
        return $this->hasMany(StudentCourse::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopePaid($query)
    {
        return $query->where('is_paid', true);
    }

    public function scopeFree($query)
    {
        return $query->where('is_paid', false);
    }

    public function scopeNotStarted($query)
    {
        return $query->whereDoesntHave('studentCourses', function ($query): void {
            $query->where('status', 'not_started');
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(CourseCategory::class, 'course_category_id');
    }

    public function scopeFutureCourses($query)
    {
        return $query->where('status', 'future_payment');
    }

    public function scopeCurrentCourses($query)
    {
        return $query->where('status', 'registered');
    }

    public function scopePastCourses($query): mixed
    {
        return $query->where('status', 'completed');
    }

    public function scopeInProgress($query): mixed
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query): mixed
    {
        return $query->where('status', 'completed');
    }

    public function scopeFuturePayment($query): mixed
    {
        return $query->where('status', 'future_payment');
    }

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

    public function CourseGrade(): BelongsTo
    {
        return $this->belongsTo(CourseGrades::class);
    }

    public function ClassGroups(): HasMany
    {
        return $this->hasMany(ClassGroup::class);
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class);
    }
}
