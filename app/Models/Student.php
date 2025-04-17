<?php

namespace App\Models;

use App\Enums\StudentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Student extends Model
{
    use HasFactory, Notifiable, softDeletes;

    protected $fillable = [
        'enrollment_date',
        'user_id',
        'program_id',
        'student_id',
        'CGPA',
        'department_id',
        'term_id',
        'status',
    ];

    protected $attributes = [
        'CGPA' => 0.00,
        'status' => StudentStatus::ENROLLED->value,
    ];

    protected $casts = [
        'status' => StudentStatus::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_student')
//            ->withPivot('enrolled_date')
            ->withPivot(['status', 'grade', 'attempt'])
            ->withTimestamps();
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function course()
    {
        return $this->belongsToMany(Course::class, 'course_student')
            ->withPivot('enrolled_date')
            ->withTimestamps();
    }

    public function terms()
    {
        return $this->hasManyThrough(Term::class, Enrollment::class, 'student_id', 'id', 'id', 'term_id')
            ->with('courses');
    }

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

    protected static function boot(): void
    {
        parent::boot();

        // Generate student_id before creating a new student
        static::creating(function ($student): void {
            $student->student_id = static::generateStudentId();
        });
    }

    public static function generateStudentId(): string
    {
        $prefix = 'STU';
        $year = date('Y');
        $randomNumber = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);

        return "$prefix$year-$randomNumber";
    }

    public function academicProgress(): HasMany
    {
        return $this->hasMany(AcademicProgress::class);
    }

    public function programAdvisors(): belongsTo
    {
        return $this->belongsTo(ProgramAdvisor::class);
    }
}
