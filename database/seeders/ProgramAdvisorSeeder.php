<?php

namespace Database\Seeders;

use App\Models\ProgramAdvisor;
use Illuminate\Database\Seeder;

class ProgramAdvisorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        programAdvisor::factory(10)->create();
    }
}
