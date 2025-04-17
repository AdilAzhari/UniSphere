<?php

namespace Database\Factories;

use App\Enums\PaymentStatus;
use App\Enums\ProctorApprovalStatus;
use App\Enums\RegistrationStatus;
use App\Models\Course;
use App\Models\Proctor;
use App\Models\Registration;
use App\Models\Student;
use App\Models\Term;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Registration>
 */
class RegistrationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => Student::query()->inRandomOrder()->first()->id ?? Student::factory()->create()->id,
            'course_id' => Course::query()->inRandomOrder()->first()->id ?? Course::factory()->create()->id,
            'proctor_id' => Proctor::query()->inRandomOrder()->first()->id ?? Proctor::factory()->create()->id,
            'term_id' => Term::query()->inRandomOrder()->first()->id ?? Term::factory()->create()->id,
            'registration_status' => $this->faker->randomElement(RegistrationStatus::cases())->value,
            'proctor_approval_status' => $this->faker->randomElement(ProctorApprovalStatus::cases())->value,
            'proctored' => $this->faker->boolean(),
            'payment_status' => $this->faker->randomElement(PaymentStatus::cases())->value,
            'completion_date' => $this->faker->date(),
        ];
    }
}
