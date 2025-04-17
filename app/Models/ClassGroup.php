<?php

namespace App\Models;

use Database\Factories\ClassGroupFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassGroup extends Model
{
    /** @use HasFactory<ClassGroupFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'group_number',
        'semester',
        'schedule',
        'year',
        'max_students',
        'current_students',
        'course_id',
        'teacher_id',
        'term_id',
    ];

    /**
     * Define the relationships between ClassGroup and other models.
     */

    /**
     * Get the course associated with this class group.
     * Each class group belongs to a single course.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the teacher assigned to this class group.
     * Each class group has one teacher.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get the academic term associated with this class group.
     * Each class group is linked to a specific academic term.
     */
    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }
}
