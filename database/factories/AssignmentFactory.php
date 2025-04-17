<?php

namespace Database\Factories;

use App\Models\Assignment;
use App\Models\ClassGroup;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\Week;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Assignment>
 */
class AssignmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'class_group_id' => ClassGroup::inRandomOrder()->first()->id,
            'course_id' => Course::inRandomOrder()->first()->id,
            'week_id' => week::inRandomOrder()->first()->id,
            'teacher_id' => Teacher::inRandomOrder()->first()->id,
            'title' => $this->faker->sentence(),
            'description' => $this->faker->sentence(),
            'deadline' => $this->faker->dateTimeThisYear(),
            'total_marks' => $this->faker->randomNumber(),
            'status' => $this->faker->randomElement(['pending', 'completed', 'overdue']),
            'file' => $this->faker->word(),
            'max_attempts' => 3,
            'passing_score' => $this->faker->numberBetween(60, 100),
            'attachment_limit' => $this->faker->randomNumber(),
            'late_submission_policy' => $this->faker->randomElement([
                'NotAllowed', 'Allowed',
            ]),
            'is_visible' => false,
            'slug' => $this->faker->slug(),
            'grading_type' => $this->faker->randomElement(['Numeric', 'Letter', 'PassFail']),
            'created_by' => Teacher::inRandomOrder()->first()->id,
            'updated_by' => Teacher::inRandomOrder()->first()->id,
            'assessment_end' => $this->faker->dateTimeThisYear(),
            'assessment_start' => $this->faker->dateTimeThisYear(),
            'submission_end' => $this->faker->dateTimeThisYear(),
            'submission_start' => $this->faker->dateTimeThisYear(),
        ];
    }
}
