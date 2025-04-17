<?php

namespace Database\Factories;

use App\Models\ProgramType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProgramType>
 */
class ProgramTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->unique()->word(),
        ];
    }
}
