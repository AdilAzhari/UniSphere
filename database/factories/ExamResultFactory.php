<?php

namespace Database\Factories;

use App\Enums\ExamStatus;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ExamResult>
 */
class ExamResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'exam_id' => Exam::inRandomOrder()->first()->id ?? Exam::factory()->create()->id,
            'student_id' => Student::inRandomOrder()->first()->id ?? Student::factory()->create()->id,
            'score' => $this->faker->randomFloat(2, 0, 100),
            'status' => $this->faker->randomElement([ExamStatus::PASSED, ExamStatus::FAILED, ExamStatus::ABSENT]),
            'notes' => $this->faker->sentence(),
        ];
    }
}
