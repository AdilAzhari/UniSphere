<?php

namespace Database\Seeders;

use App\Models\AssignmentSubmission;
use Illuminate\Database\Seeder;

class AssignmentSubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AssignmentSubmission::factory(10)->create();
    }
}
