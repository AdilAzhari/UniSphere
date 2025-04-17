<?php

namespace Database\Factories;

use App\Models\ClassGroup;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\Term;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClassGroupFactory extends Factory
{
    protected $model = ClassGroup::class;

    public function definition(): array
    {
        return [
            'group_number' => $this->faker->numberBetween(1, 10),
            'semester' => $this->faker->randomElement(['Fall', 'Spring', 'Summer']),
            'schedule' => $this->faker->word(),
            'year' => $this->faker->numberBetween(1, 4),
            'max_students' => $this->faker->numberBetween(20, 40),
            'current_students' => $this->faker->numberBetween(0, 20),
            'course_id' => Course::inRandomOrder()->first()->id ?? Course::factory()->create()->id,
            'teacher_id' => Teacher::inRandomOrder()->first()->id ?? Teacher::factory()->create()->id,
            'term_id' => Term::inRandomOrder()->first()->id ?? Term::factory()->create()->id,
        ];
    }
}
