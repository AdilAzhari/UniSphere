<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcademicAchievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'gpa', 'credits_earned', 'honors_awards', 'student_id', 'term_id',
    ];

    /*
    * @belong
    */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Define a relationship where an academic achievement belongs to a term.
     * Each academic achievement is recorded for a specific term.
     */
    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }
}
