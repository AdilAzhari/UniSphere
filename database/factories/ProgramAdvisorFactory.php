<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\ProgramAdvisor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProgramAdvisor>
 */
class ProgramAdvisorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => $this->faker->randomElement([false, true, false]),
            'department_id' => Department::inRandomOrder()->first(),
            'max_students' => $this->faker->numberBetween(1, 10),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
        ];
    }
}
