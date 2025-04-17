<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Week extends Model
{
    use HasFactory;

    protected $fillable = [
        'week_number',
        'start_date',
        'end_date',
        'course_id',
        'assignment_id',
        'term_id',
        'title',
        'description',
        'announcement',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

    public function materials(): HasMany
    {
        return $this->hasMany(Material::class);
    }

    public function learningGuide(): HasOne
    {
        return $this->HasOne(LearningGuidance::class);
    }

    public function assignment(): HasOne
    {
        return $this->HasOne(Assignment::class);
    }
}
