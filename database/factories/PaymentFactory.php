<?php

namespace Database\Factories;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Enums\PaymentTransactionType;
use App\Models\Course;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => $this->faker->randomFloat(2, 0, 1000),
            'payment_date' => $this->faker->dateTime(),
            'student_id' => Student::query()->inRandomOrder()->first()->id ?? student::factory()->create()->id,
            'course_id' => Course::query()->inRandomOrder()->first()->id ?? course::factory()->create()->id,
            'status' => $this->faker->randomElement(PaymentStatus::cases())->value,
            'transaction_type' => $this->faker->randomElement(PaymentTransactionType::cases())->value,
            'method' => $this->faker->randomElement(PaymentMethod::cases())->value,
            'failure_reason' => $this->faker->sentence(),
            'payment_intent' => $this->faker->uuid(),
            'refund_id' => $this->faker->uuid(),
            'created_at' => $this->faker->dateTimeThisYear(),
            'updated_at' => $this->faker->dateTimeThisYear(),
        ];
    }
}
