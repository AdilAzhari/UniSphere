<?php

namespace Database\Seeders;

use App\Models\ProgramType;
use Illuminate\Database\Seeder;

class ProgramTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProgramType::factory()->count(5)->create();
    }
}
