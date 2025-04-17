<?php

namespace Database\Factories;

use App\Models\Assignment;
use App\Models\Assignment_submission;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Assignment_submission>
 */
class AssignmentSubmissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'assignment_id' => Assignment::inRandomOrder()->first()->id ?? Assignment::factory()->create()->id,
            'student_id' => Student::inRandomOrder()->first()->id ?? Student::factory()->create()->id,
            'obtained_marks' => $this->faker->randomNumber(),
            'status' => $this->faker->randomElement(['submitted', 'graded']),
            'remarks' => $this->faker->sentence(),
            'submitted_at' => $this->faker->dateTimeThisYear(),
            'graded_at' => $this->faker->dateTimeThisYear(),
            'graded_by' => Teacher::inRandomOrder()->first()->id,
            'feedback' => $this->faker->sentence(),
        ];
    }
}
