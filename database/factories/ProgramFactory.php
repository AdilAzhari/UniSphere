<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\ProgramStatus;
use App\Models\ProgramType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProgramFactory extends Factory
{
    public function definition(): array
    {
        return [
            'program_code' => $this->faker->unique()->regexify('[A-Z]{4}[0-9]{3}'),
            'description' => $this->faker->paragraph(),
            'duration_years' => $this->faker->numberBetween(2, 5),
            'department_id' => Department::inRandomOrder()->first()->id ?? Department::factory()->create()->id,
            'program_name' => $this->faker->words(3, true),
            'program_type_id' => ProgramType::inRandomOrder()->first()->id ?? ProgramType::factory()->create()->id,
            'program_status_id' => ProgramStatus::inRandomOrder()->first()->id ?? ProgramStatus::factory()->create()->id,
            'total_credits' => $this->faker->numberBetween(90, 160),
        ];
    }
}
