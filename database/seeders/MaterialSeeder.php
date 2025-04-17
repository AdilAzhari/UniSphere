<?php

namespace Database\Seeders;

use App\Models\material;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Material::factory()->count(300)->create();
    }
}
