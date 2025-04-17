<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'question',
        'created_by',
        'updated_by',
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(QuizAnswer::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'updated_by');
    }

    public function quizQuestionOptions(): HasMany
    {
        return $this->hasMany(QuizQuestionOption::class);
    }

    public function quizQuestionAnswers(): HasMany
    {
        return $this->hasMany(QuizAnswer::class);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($QuizQuestion): void {
            // Skip the logic if the model is being created via a factory
            if (isset($QuizQuestion->__laravel_creating_via_factory) && $QuizQuestion->__laravel_creating_via_factory) {
                return;
            }

            if (auth()->check()) {
                $QuizQuestion->created_by = auth()->id();
                $QuizQuestion->updated_by = auth()->id();
            }
        });

        static::updating(function ($QuizQuestion): void {

            if (isset($QuizQuestion->__laravel_creating_via_factory) && $QuizQuestion->__laravel_creating_via_factory) {
                return;
            }

            if (auth()->check()) {
                $QuizQuestion->updated_by = auth()->id();
            }
        });
    }
}
