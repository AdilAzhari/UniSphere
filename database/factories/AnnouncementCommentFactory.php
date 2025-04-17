<?php

namespace Database\Factories;

use App\Models\Announcement;
use App\Models\AnnouncementComment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AnnouncementComment>
 */
class AnnouncementCommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'announcement_id' => Announcement::inRandomOrder()->first()->id ?? Announcement::factory()->create()->id,
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory()->create()->id,
            'comment' => $this->faker->sentence(),
            'parent_id' => null,
            'commented_by' => User::inRandomOrder()->first()->id ?? User::factory()->create()->id,
        ];
    }
}
