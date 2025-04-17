<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Grading_scale;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Grading_scale>
 */
class GradingScaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'grade' => $this->faker->word(),
            'student_id' => Student::inRandomOrder()->first()->id ?? Student::factory()->create()->id,
            'course_id' => Course::inRandomOrder()->first()->id ?? Course::factory()->create()->id,
            'min_score' => $this->faker->randomFloat(2, 0, 100),
            'max_score' => $this->faker->randomFloat(2, 0, 100),
            'gpa_point' => $this->faker->randomFloat(2, 0, 4),
        ];
    }
}
