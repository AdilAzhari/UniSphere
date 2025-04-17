<?php

namespace Database\Seeders;

use App\Models\PeerReview;
use Illuminate\Database\Seeder;

class PeerReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PeerReview::factory()->count(5)->create();
    }
}
