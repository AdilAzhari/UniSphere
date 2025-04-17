<?php

namespace Database\Factories;

use App\Enums\ContentType;
use App\Enums\FileType;
use App\Models\Course;
use App\Models\Material;
use App\Models\Teacher;
use App\Models\Week;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Material>
 */
class MaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'course_id' => Course::query()->inRandomOrder()->first()->id ?? Course::factory()->create()->id,
            'created_by' => Teacher::query()->inRandomOrder()->first()->id ?? Teacher::factory()->create()->id,
            'updated_by' => Teacher::query()->inRandomOrder()->first()->id ?? Teacher::factory()->create()->id,
            'week_id' => Week::query()->inRandomOrder()->first()->id ?? Week::factory()->create()->id,
            'type' => $this->faker->randomElement(FileType::values()),
            'content_type' => $this->faker->randomElement(ContentType::values()),
            'thumbnail' => $this->faker->imageUrl(),
            'size' => $this->faker->randomNumber(5),
            'path' => 'materials/'.$this->faker->uuid(),
            'url' => $this->faker->url(),
            'filename' => $this->faker->slug().'.'.$this->faker->fileExtension(),
            'original_filename' => $this->faker->word().'.'.$this->faker->fileExtension(),
            'disk' => $this->faker->randomElement(['local', 'public', 's3']),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
        ];
    }
}
