<?php

namespace App\Models;

use Database\Factories\AssignmentCommentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssignmentComment extends Model
{
    /** @use HasFactory<AssignmentCommentFactory> */
    use HasFactory;

    protected $fillable = [
        'assignment_id',
        'commented_by',
        'comment',
    ];

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class);
    }

    public function comment(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
