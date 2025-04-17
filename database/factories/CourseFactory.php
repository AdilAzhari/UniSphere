<?php

namespace Database\Factories;

use App\Enums\CoursePayment;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Program;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'code' => strtoupper($this->faker->bothify('??###')),
            'credit_hours' => $this->faker->numberBetween(1, 4),
            'description' => $this->faker->text(400),
            'syllabus' => $this->faker->word(),
            'image' => $this->faker->url(),
            'status' => $this->faker->boolean(),
            'require_proctor' => $this->faker->boolean(),
            'paid' => $this->faker->randomElement(CoursePayment::cases())->value,
            'cost' => $this->faker->randomFloat(2, 0, 150),
            'program_id' => Program::query()->inRandomOrder()->first()?->id
                ?? Program::factory()->create()->id,
            'course_category_id' => CourseCategory::query()->inRandomOrder()->first()?->id
                ?? CourseCategory::factory()->create()->id,
            'prerequisite_course_id' => Course::query()->inRandomOrder()->first()?->id ?? null,
        ];
    }
}
