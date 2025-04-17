<?php

namespace Database\Seeders;

use App\Models\ClassGroup;
use Illuminate\Database\Seeder;

class ClassGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ClassGroup::factory(10)->create();
    }
}
