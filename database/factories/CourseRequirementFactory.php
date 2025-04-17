<?php

namespace Database\Factories;

use App\Models\CourseCategory;
use App\Models\CourseRequirement;
use App\Models\Program;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CourseRequirement
 */
class CourseRequirementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'program_id' => Program::inRandomOrder()->first()->id ?? Program::factory()->create()->id,
            'course_category_id' => CourseCategory::inRandomOrder()->first()->id ?? CourseCategory::factory()->create()->id,
            'required_courses' => $this->faker->numberBetween(1, 4),
        ];
    }
}
