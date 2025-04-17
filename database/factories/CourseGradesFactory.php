<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\CourseGrades;
use App\Models\Student;
use App\Models\Term;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CourseGrades>
 */
class CourseGradesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => Student::inRandomOrder()->first()->id ?? Student::factory()->create()->id,
            'term_id' => Term::inRandomOrder()->first()->id ?? Term::factory()->create()->id,
            'course_id' => Course::inRandomOrder()->first()->id ?? Course::factory()->create()->id,
            'grade' => $this->faker->randomFloat(2, 0, 100), // Grade between 0 and 100
            'credits' => $this->faker->numberBetween(1, 4),
        ];
    }
}
