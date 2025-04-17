<?php

namespace Database\Factories;

use App\Enums\TeacherStatus;
use App\Models\department;
use App\Models\program;
use App\Models\Teachers;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Teachers>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory()->create()->id,
            'qualification' => $this->faker->word(),
            'experience' => $this->faker->numberBetween(1, 20),
            'specialization' => $this->faker->word(),
            'designation' => $this->faker->word(),
            'hire_date' => $this->faker->dateTimeThisYear(),
            'status' => $this->faker->randomElement([TeacherStatus::ACTIVE, TeacherStatus::INACTIVE]),
            'program_id' => program::inRandomOrder()->first()->id ?? program::factory()->create()->id,
            'department_id' => department::inRandomOrder()->first()->id ?? department::factory()->create()->id,
        ];
    }
}
