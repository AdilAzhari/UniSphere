<?php

namespace Database\Seeders;

use App\Models\AssignmentSubmissionFile;
use Illuminate\Database\Seeder;

class AssignmentSubmissionFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AssignmentSubmissionFile::factory()->count(20)->create();
    }
}
