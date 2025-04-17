<?php

namespace Database\Seeders;

use App\Models\CourseRequirement;
use Illuminate\Database\Seeder;

class CourseRequirementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CourseRequirement::factory()->count(20)->create();
    }
}
