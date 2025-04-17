<?php

namespace Database\Factories;

use App\Enums\ProctorStatus;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Term;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnrollmentFactory extends Factory
{
    protected $model = Enrollment::class;

    public function definition(): array
    {
        $course = Course::query()->inRandomOrder()->first() ?? Course::factory()->create();
        $student = Student::query()->first() ?? Student::factory()->create();
        $term = Term::query()->first() ?? Term::factory()->create();

        // Ensure valid date ranges
        $enrollmentDate = $this->faker->dateTimeBetween($term->start_date, $term->end_date);
        $completionDate = $this->faker->dateTimeBetween($enrollmentDate, $term->end_date);

        return [
            'enrollment_date' => $enrollmentDate,
            'completion_date' => $completionDate,
            'course_id' => $course->id,
            'student_id' => $student->id,
            'enrollment_status' => $this->faker->randomElement(['Enrolled', 'Pending', 'Completed', 'Dropped']),
            'grade' => $this->faker->numberBetween(60, 100),
            'grade_points' => $this->faker->randomFloat(2, 0, 100),
            'term_id' => $term->id,
            'proctor_status' => $this->faker->randomElement(ProctorStatus::cases())->value,
        ];
    }
}
