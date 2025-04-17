<?php

namespace Database\Seeders;

use App\Models\StoryComment;
use Illuminate\Database\Seeder;

class StoryCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StoryComment::factory()
            ->count(10)
            ->create();
    }
}
