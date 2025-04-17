<?php

namespace App\Models;

use Database\Factories\AssignmentSubmissionFileFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssignmentSubmissionFile extends Model
{
    /** @use HasFactory<AssignmentSubmissionFileFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * These fields can be filled using mass assignment.
     *
     * @var array<string>
     */
    protected $fillable = [
        'assignment_submission_id', // Reference to the related assignment submission
        'file_path',
    ];

    /**
     * Get the assignment submission associated with this file.
     * Each submission file belongs to a single assignment submission.
     */
    public function assignmentSubmission(): BelongsTo
    {
        return $this->belongsTo(AssignmentSubmission::class);
    }
}
