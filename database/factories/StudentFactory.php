<?php

namespace Database\Factories;

use App\Enums\StudentStatus;
use App\Models\department;
use App\Models\Program;
use App\Models\Student;
use App\Models\Term;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'enrollment_date' => $this->faker->dateTimeThisYear(),
            'created_at' => $this->faker->dateTimeThisYear(),
            'program_id' => Program::inRandomOrder()->first()?->id ?? Program::factory()->create()->id,
            'department_id' => Department::inRandomOrder()->first()?->id ?? \App\Models\Department::factory()->create()->id,
            'term_id' => Term::inRandomOrder()->first()?->id ?? Term::factory()->create()->id,
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory()->create()->id,
            'student_id' => 'STU'.Str::uuid()->toString(),
            'address' => $this->faker->address(),
            'phone_number' => $this->faker->phoneNumber(),
            'date_of_birth' => $this->faker->date(),
            'status' => $this->faker->randomElement(StudentStatus::values()),
        ];
    }
}
