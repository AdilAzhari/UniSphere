<?php

namespace Database\Seeders;

use App\Models\Proctor;
use Illuminate\Database\Seeder;

class ProctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Proctor::factory()->count(10)->create();
    }
}
