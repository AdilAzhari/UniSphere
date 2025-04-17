<?php

namespace Database\Seeders;

use App\Models\TechnicalTeam;
use Illuminate\Database\Seeder;

class TechnicalTeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TechnicalTeam::factory()->count(10)->create();
    }
}
