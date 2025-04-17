<?php

namespace Database\Factories;

use App\Models\Assignment;
use App\Models\AssignmentComment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AssignmentComment>
 */
class AssignmentCommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'assignment_id' => Assignment::factory(),
            'comment' => $this->faker->realText(),
            'commented_by' => User::factory(),
        ];
    }
}
