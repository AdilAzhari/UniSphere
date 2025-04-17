<?php

namespace Database\Seeders;

use App\Models\AssignmentAttachment;
use Illuminate\Database\Seeder;

class AssignmentAttachmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AssignmentAttachment::factory()->count(10)->create();
    }
}
