<?php

namespace Database\Factories;

use App\Models\ClassGroup;
use App\Models\Course;
use App\Models\Exams;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Exams>
 */
class ExamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'course_id' => Course::query()->first()->id ?? Course::factory()->create()->id,
            'class_group_id' => ClassGroup::query()->first()->id ?? ClassGroup::factory()->create()->id,
            'teacher_id' => Teacher::query()->first()->id ?? Teacher::factory()->create()->id,
            'created_at' => $this->faker->dateTimeThisYear(),
            'exam_date' => $this->faker->dateTimeThisYear(),
            'exam_description' => $this->faker->sentence(),
            'exam_duration' => $this->faker->randomNumber(),
            'exam_rules' => $this->faker->sentence(),
            'created_by' => User::query()->first()->id ?? User::factory()->create()->id,
            'updated_by' => User::query()->first()->id ?? User::factory()->create()->id,
            'exam_passing_score' => $this->faker->randomNumber(),
            'exam_code' => $this->faker->unique()->randomNumber(),
        ];
    }
}
