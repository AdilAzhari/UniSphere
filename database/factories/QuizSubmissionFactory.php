<?php

namespace Database\Factories;

use App\Models\Quiz;
use App\Models\QuizSubmission;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<QuizSubmission>
 */
class QuizSubmissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quiz_id' => Quiz::inRandomOrder()->first()->id ?? Quiz::factory()->create()->id,
            'student_id' => Student::inRandomOrder()->first()->id ?? Student::factory()->create()->id,
            'score' => $this->faker->numberBetween(0, 100), // Assuming score is out of 100
            'status' => $this->faker->randomElement(['pending', 'submitted', 'graded']),
            'submitted_at' => $this->faker->optional()->dateTimeBetween('-1 month'),
            'graded_at' => $this->faker->optional()->dateTimeBetween('-1 month'),
            'graded_by' => Teacher::inRandomOrder()->first()->id ?? Teacher::factory()->create()->id,
            'feedback' => $this->faker->optional()->sentence(),
            'remarks' => $this->faker->optional()->paragraph(),
        ];
    }
}
