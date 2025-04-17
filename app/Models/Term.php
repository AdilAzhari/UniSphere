<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Term extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'slug',
        'max_courses',
        'is_current',
        'registration_start_date',
        'registration_end_date',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_current' => 'boolean',
    ];

    protected $attributes = [
        'max_courses' => 40,
    ];

    public function classes(): HasMany
    {
        return $this->hasMany(ClassGroup::class);
    }

    public function currentStudents(): HasMany
    {
        return $this->hasMany(Student::class, 'current_term_id');
    }

    public function currentTerm(): BelongsTo
    {
        return $this->belongsTo(Term::class, 'term_id');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class);
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }
}
