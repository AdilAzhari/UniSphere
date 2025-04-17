<?php

namespace Database\Factories;

use App\Models\AssignmentSubmission;
use App\Models\AssignmentSubmissionFile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AssignmentSubmissionFile>
 */
class AssignmentSubmissionFileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'submission_id' => AssignmentSubmission::factory()->create()->id,
            'file_path' => $this->faker->filePath(),
        ];
    }
}
