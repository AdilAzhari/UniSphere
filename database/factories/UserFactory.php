<?php

namespace Database\Factories;

use App\Enums\GenderType;
use App\Enums\MaritalStatus;
use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'middle_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'Preferred_name' => fake()->name(),
            'avatar' => fake()->imageUrl(),
            'zip_code' => fake()->postcode(),
            'state' => fake()->state(),
            'city_of_residence' => fake()->city(),
            'phone_number' => fake()->phoneNumber(),
            'date_of_birth' => fake()->date(),
            'nationality' => fake()->country(),
            'country_of_residence' => fake()->country(),
            'status' => fake()->randomElement(UserStatus::cases())->value,
            'marital_status' => fake()->randomElement(MaritalStatus::cases())->value,
            'gender' => fake()->randomElement(GenderType::cases())->value,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
