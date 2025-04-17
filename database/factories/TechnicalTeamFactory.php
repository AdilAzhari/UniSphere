<?php

namespace Database\Factories;

use App\Enums\TechnicalTeamRole;
use App\Enums\TechnicalTeamStatus;
use App\Models\TechnicalTeam;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TechnicalTeam>
 */
class TechnicalTeamFactory extends Factory
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
            'role' => $this->faker->randomElement([TechnicalTeamRole::SUPPORT, TechnicalTeamRole::ADMIN, TechnicalTeamRole::MANAGER]),
            'status' => $this->faker->randomElement([TechnicalTeamStatus::ACTIVE, TechnicalTeamStatus::INACTIVE]),
        ];
    }
}
