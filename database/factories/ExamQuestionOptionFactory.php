<?php

namespace Database\Factories;

use App\Models\ExamQuestion;
use App\Models\ExamQuestionOption;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ExamQuestionOption>
 */
class ExamQuestionOptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'option_text' => $this->faker->word(),
            'is_correct' => $this->faker->boolean(25), // 25% chance of being correct
            'created_by' => Teacher::inRandomOrder()->first()->id ?? Teacher::factory()->create()->id,
            'updated_by' => Teacher::inRandomOrder()->first()->id ?? Teacher::factory()->create()->id,
            'exam_question_id' => ExamQuestion::inRandomOrder()->first()->id,
        ];
    }
}
