<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuizQuestionOption extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'quiz_question_id',
        'option',
        'is_correct',
        'created_by',
        'updated_by',
    ];

    public function quizQuestion(): BelongsTo
    {
        return $this->belongsTo(QuizQuestion::class);
    }

    protected static function boot(): void
    {
        parent::boot();

        // Update the updated_by and created_by field when saving
        static::saving(function ($model): void {
            $model->updated_by = auth()->id();
            $model->created_by = auth()->id();
        });
        static::creating(function ($model): void {
            $model->created_by = auth()->id();
            $model->updated_by = auth()->id();
        });

    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'updated_by');
    }
}
