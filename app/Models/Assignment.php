<?php

namespace App\Models;

use App\Enums\AssignmentStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Assignment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     * These fields can be filled using mass assignment.
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'description',
        'file',
        'deadline',
        'total_marks',
        'course_id',
        'created_by',
        'updated_by',
        'submission_start',
        'submission_end',
        'assessment_start',
        'assessment_end',
        'is_visible',
        'grading_type',
        'status',
        'class_group_id',
        'teacher_id',
        'max_attempts',
        'passing_score',
        'instructions',
        'attachment_limit',
        'late_submission_policy',
    ];

    /**
     * The attributes that should be hidden for serialization.
     * These fields will not be included when converting the model to an array or JSON.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'deleted_at',
        'updated_by',
    ];

    /**
     * The attributes that should be cast to native types.
     * Automatically converts fields to appropriate data types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'deadline' => 'datetime',
        'submission_start' => 'datetime',
        'submission_end' => 'datetime',
        'assessment_start' => 'datetime',
        'assessment_end' => 'datetime',
        'is_visible' => 'boolean',
        'total_marks' => 'float',
        'max_attempts' => 'integer',
        'passing_score' => 'float',
        'attachment_limit' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status' => AssignmentStatus::PENDING,
        'is_visible' => true,
        'max_attempts' => 1,
        'attachment_limit' => 1,
        'grading_type' => 'numeric', // Options: numeric, letter, pass_fail
        'late_submission_policy' => 'NotAllowed', // Options: not_allowed, allowed_with_penalty, allowed
    ];

    /**
     * The accessors to append to the model's array form.
     * These attributes are dynamically added when retrieving the model as an array.
     *
     * @var array
     */
    protected $appends = [
        'is_active',
        'submission_status',
    ];

    /**
     * Get the class group associated with the assignment.
     */
    public function classGroup(): BelongsTo
    {
        return $this->belongsTo(ClassGroup::class)
            ->withDefault(['name' => '']);
    }

    /**
     * Get the teacher who created the assignment.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    /**
     * Get the user who created the assignment.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated the assignment.
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the course associated with the assignment.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get all submissions made for this assignment.
     */
    public function submissions(): HasMany
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    /**
     * Scope a query to only include visible assignments.
     */
    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_visible', true);
    }

    /**
     * Scope a query to only include active assignments.
     * Active means the submission end date has not yet passed.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('submission_end', '>=', now());
    }

    /**
     * Determine if the assignment is currently active.
     */
    public function getIsActiveAttribute(): bool
    {
        return now()->between($this->submission_start, $this->submission_end);
    }

    /**
     * Get the current submission status of the assignment.
     */
    public function getSubmissionStatusAttribute(): string
    {
        return now() < $this->submission_start ? 'upcoming' : (now() > $this->submission_end ? 'closed' : 'open');
    }

    /**
     * Check if late submissions are allowed based on the policy.
     */
    public function allowsLateSubmissions(): bool
    {
        return in_array($this->late_submission_policy, ['allowed', 'allowed_with_penalty']);
    }

    /**
     * Get the URL of the attached file, if available.
     */
    public function getFileUrlAttribute(): ?string
    {
        return $this->file ? Storage::url($this->file) : null;
    }
}
