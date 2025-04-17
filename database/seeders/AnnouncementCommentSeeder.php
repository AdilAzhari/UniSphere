<?php

namespace Database\Seeders;

use App\Models\AnnouncementComment;
use Illuminate\Database\Seeder;

class AnnouncementCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AnnouncementComment::factory()->count(100)->create();
    }
}
