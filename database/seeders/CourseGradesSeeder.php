<?php

namespace Database\Seeders;

use App\Models\CourseGrades;
use Illuminate\Database\Seeder;

class CourseGradesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CourseGrades::factory(1000)->create();
    }
}
