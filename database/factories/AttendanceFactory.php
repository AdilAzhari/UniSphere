<?php

namespace Database\Factories;

use App\Enums\AttendanceReason;
use App\Models\Attendance;
use App\Models\ClassGroup;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->dateTimeThisYear(),
            'status' => $this->faker->randomElement(['present', 'absent']),
            'reason' => $this->faker->randomElement(AttendanceReason::values()),
            'notes' => $this->faker->text(),
            'student_id' => Student::inRandomOrder()->first()->id ?? Student::factory()->create()->id,
            'enrollment_id' => Enrollment::inRandomOrder()->first()->id ?? Enrollment::factory()->create()->id,
            'class_group_id' => ClassGroup::inRandomOrder()->first()->id ?? ClassGroup::factory()->create()->id,
            'teacher_id' => Teacher::inRandomOrder()->first()->id ?? Teacher::factory()->create()->id,
        ];
    }
}
