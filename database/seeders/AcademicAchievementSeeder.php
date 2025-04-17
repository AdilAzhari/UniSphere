<?php

namespace Database\Seeders;

use App\Models\AcademicAchievement;
use Illuminate\Database\Seeder;

class AcademicAchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AcademicAchievement::factory(100)->create();
    }
}
