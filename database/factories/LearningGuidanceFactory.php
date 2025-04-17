<?php

namespace Database\Factories;

use App\Models\LearningGuidance;
use App\Models\Week;
use Illuminate\Database\Eloquent\Factories\Factory;

class LearningGuidanceFactory extends Factory
{
    protected $model = LearningGuidance::class;

    public function definition(): array
    {
        return [
            'week_id' => Week::factory(), // Assuming Week factory exists
            'overview' => $this->faker->sentence(),
            'topics' => $this->faker->randomElements([
                'Introduction',
                'Network Security',
                'Security Protocols: SSL and HTTPS',
                'C.I.A. Triad',
            ], 3),
            'objectives' => $this->faker->sentences(3),
            'tasks' => $this->faker->sentences(3),
        ];
    }
}
