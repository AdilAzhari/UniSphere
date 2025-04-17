<?php

namespace Database\Factories;

use App\Models\Story;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Story>
 */
class StoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraphs(3, true),
            'image' => $this->faker->imageUrl(),
            'student_id' => Student::inRandomOrder()->first()->id,
            'status' => $this->faker->randomElement(['draft', 'published']),
            'published_at' => $this->faker->dateTimeBetween('-1 year'),
        ];
    }
}
