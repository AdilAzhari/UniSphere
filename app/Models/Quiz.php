<?php

namespace App\Models;

use App\Enums\QuizDuration;
use App\Enums\QuizStatus;
use App\Enums\QuizType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    use HasFactory;

    /**
     * @type array<string>
     */
    protected $fillable = [
        'course_id',
        'title',
        'instructions',
        'description',
        'duration',
        'passing_score',
        'teacher_id',
        'week_id',
        'class_group_id',
        'type',
        'code',
        'status',
        'created_by',
        'updated_by',
        'start_date',
        'end_date',
    ];

    protected $attributes = [
        'type' => QuizType::UNGRADED,
        'status' => QuizStatus::PUBLISHED,
    ];

    /**
     * @type array<string,array>
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'status' => QuizStatus::class,
        'type' => QuizType::class,
        'duration' => QuizDuration::class,
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function classGroup(): BelongsTo
    {
        return $this->belongsTo(ClassGroup::class);
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(QuizSubmission::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(QuizQuestion::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(QuizAnswer::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class);
    }

    public function week(): BelongsTo
    {
        return $this->belongsTo(Week::class);
    }
}
