<?php

namespace Database\Factories;

use App\Models\Assignment;
use App\Models\AssignmentAttachment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AssignmentAttachment>
 */
class AssignmentAttachmentFactory extends Factory
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
            'file_path' => $this->faker->imageUrl(),
        ];
    }
}
