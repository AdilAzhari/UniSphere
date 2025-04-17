<?php

namespace Database\Seeders;

use App\Models\enrollment;
use Illuminate\Database\Seeder;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        enrollment::factory(500)->create();
    }
}
