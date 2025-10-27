<?php

namespace Database\Seeders;

use App\Models\Advertisement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VerifyExistingAdvertisementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update all existing advertisements to be verified
        $updated = Advertisement::where('is_verified', false)
            ->orWhereNull('is_verified')
            ->update(['is_verified' => true]);

        $this->command->info("Verified {$updated} existing advertisements.");
    }
}
