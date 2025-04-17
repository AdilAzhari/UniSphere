<?php

namespace Database\Factories;

use App\Models\Term;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TermFactory extends Factory
{
    protected $model = Term::class;

    public function definition(): array
    {
        $startDate = now()->addMonths(2);
        $endDate = now()->addMonths(4);

        return [
            'name' => $this->faker->unique()->words(2, true),
            'slug' => Str::slug($this->faker->unique()->words(2, true)),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'max_courses' => $this->faker->numberBetween(20, 40),
            'registration_start_date' => now()->addMonths(1),
            'registration_end_date' => now()->addMonths(2),
        ];
    }

    public function past(): self
    {
        return $this->state(function (array $attributes) {
            $startDate = now()->subMonths(6);
            $endDate = now()->subMonths(3);

            return [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'registration_start_date' => now()->subMonths(7),
                'registration_end_date' => now()->subMonths(6),
            ];
        });
    }

    public function current(): self
    {
        return $this->state(function (array $attributes) {
            $startDate = now()->subMonths(1);
            $endDate = now()->addMonths(2);

            return [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'registration_start_date' => now()->subMonths(2),
                'registration_end_date' => now()->subMonths(1),
            ];
        });
    }

    public function future(): self
    {
        return $this->state(function (array $attributes) {
            $startDate = now()->addMonths(3);
            $endDate = now()->addMonths(6);

            return [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'registration_start_date' => now()->addMonths(2),
                'registration_end_date' => now()->addMonths(3),
            ];
        });
    }
}
