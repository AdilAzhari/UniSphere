<?php

namespace Database\Seeders;

use App\Models\ExamQuestionOption;
use Illuminate\Database\Seeder;

class ExamQuestionOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExamQuestionOption::factory(20)->create();
    }
}
