<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcademicProgress extends Model
{
    use HasFactory;

    // Specifies the attributes that can be mass assigned
    protected $fillable = [
        'student_id',
        'program_id',
        'term_id',
        'gpa',
        'cgpa',
        'progress_percentage',
        'academic_standing',
        'total_credits',
        'total_courses',
        'total_courses_completed',
        'total_courses_failed',
        'total_courses_withdrawn',
    ];

    /**
     * Accessor to format the academic standing attribute.
     * Ensures the first letter is capitalized and the rest are lowercase.
     */
    public function getAcademicStandingAttribute(string $value): string
    {
        return ucfirst(strtolower($value));
    }

    /**
     * Mutator to round the GPA value to two decimal places before storing it.
     */
    public function setGpaAttribute(float $value): void
    {
        $this->attributes['gpa'] = round($value, 2);
    }

    /**
     * Define a relationship where an academic progress record belongs to a student.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Define a relationship where an academic progress record belongs to a program.
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Define a relationship where an academic progress record belongs to a term.
     */
    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }
}
