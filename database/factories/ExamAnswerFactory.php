<?php

namespace Database\Factories;

use App\Models\ExamAnswer;
use App\Models\ExamQuestion;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ExamAnswer>
 */
class ExamAnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Exam_question_id' => ExamQuestion::inRandomOrder()->first()->id ?? ExamQuestion::factory()->create()->id,
            'created_by' => Teacher::inRandomOrder()->first()->id ?? Teacher::factory()->create()->id,
            'updated_by' => Teacher::inRandomOrder()->first()->id ?? Teacher::factory()->create()->id,
            'answer_text' => $this->faker->word(),
            'is_correct' => $this->faker->boolean(),
        ];
    }
}
