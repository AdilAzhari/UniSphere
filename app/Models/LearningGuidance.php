<?php

namespace App\Models;

use Database\Factories\LearningGuidancesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LearningGuidance extends Model
{
    /** @use HasFactory<LearningGuidancesFactory> */
    use HasFactory;

    protected $fillable = ['week_id', 'overview', 'topics', 'objectives', 'tasks'];

    protected $casts = [
        'topics' => 'array',
        'objectives' => 'array',
        'tasks' => 'array',
    ];

    public function week(): BelongsTo
    {
        return $this->belongsTo(Week::class);
    }
}
