<?php

namespace Database\Factories;

use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ExamQuestion>
 */
class ExamQuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'exam_id' => Exam::inRandomOrder()->first()->id,
            'created_by' => Teacher::factory()->create()->id,
            'updated_by' => Teacher::factory()->create()->id,
            'question_text' => $this->faker->text(),
            'type' => $this->faker->randomElement([
                'true_false', 'multiple_choice', 'open_ended',
            ]),
        ];
    }
}
