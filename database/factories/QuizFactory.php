<?php

namespace Database\Factories;

use App\Enums\QuizDuration;
use App\Enums\QuizStatus;
use App\Enums\QuizType;
use App\Models\ClassGroup;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\Teacher;
use App\Models\Week;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Quiz>
 */
class QuizFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'course_id' => Course::inRandomOrder()->first()->id,
            'class_group_id' => ClassGroup::inRandomOrder()->first()->id,
            'week_id' => week::inRandomOrder()->first()->id,
            'teacher_id' => Teacher::inRandomOrder()->first()->id,
            'code' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'type' => $this->faker->randomElement([QuizType::GRADED, QuizType::UNGRADED]),
            'title' => $this->faker->sentence(),
            'instructions' => $this->faker->sentence(),
            'duration' => $this->faker->randomElement(QuizDuration::values()),
            'status' => $this->faker->randomElement([QuizStatus::DRAFT, QuizStatus::PUBLISHED, QuizStatus::Closed]),
            'start_date' => $this->faker->dateTimeThisYear(),
            'end_date' => $this->faker->dateTimeThisYear(),
            'passing_score' => $this->faker->randomNumber(),
        ];
    }
}
