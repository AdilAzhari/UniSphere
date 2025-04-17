<?php

namespace Database\Factories;

use App\Models\AssignmentSubmission;
use App\Models\PeerReview;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PeerReview>
 */
class PeerReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'submission_id' => AssignmentSubmission::factory()->create()->first()->id,
            'reviewer_id' => Student::factory()->create()->first()->id,
            'rating' => $this->faker->numberBetween(1, 5),
            'comments' => $this->faker->paragraph(),
        ];
    }
}
