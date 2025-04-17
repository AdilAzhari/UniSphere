<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssignmentSubmission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * These fields can be filled using mass assignment.
     *
     * @var array<string>
     */
    protected $fillable = [
        'obtained_marks',
        'assignment_id',
        'student_id',
        'is_late',
        'status',
        'remarks',
        'submitted_at',
        'graded_at',
        'graded_by',
        'feedback',
    ];

    protected $attributes = [
        'status' => 'absent',
    ];

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
