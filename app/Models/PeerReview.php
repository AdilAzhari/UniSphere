<?php

namespace App\Models;

use Database\Factories\PeerReviewFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PeerReview extends Model
{
    /** @use HasFactory<PeerReviewFactory> */
    use HasFactory;

    protected $fillable = [
        'submission_id',
        'reviewer_id',
        'comments',
        'rating',
    ];

    protected $attributes = [
        'rating' => 0,
    ];

    public function submission(): BelongsTo
    {
        return $this->belongsTo(AssignmentSubmission::class, 'submission_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
