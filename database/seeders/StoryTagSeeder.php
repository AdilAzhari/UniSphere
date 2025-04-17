<?php

namespace Database\Seeders;

use App\Models\StoryTag;
use Illuminate\Database\Seeder;

class StoryTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StoryTag::factory()
            ->count(10)
            ->create();
    }
}
