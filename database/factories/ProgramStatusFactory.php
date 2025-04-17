<?php

namespace Database\Factories;

use App\Models\ProgramStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProgramStatus>
 */
class ProgramStatusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => $this->faker->unique()->word,
        ];
    }
}
