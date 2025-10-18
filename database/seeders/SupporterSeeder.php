<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Provider;
use Illuminate\Support\Facades\Hash;

class SupporterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create supporter provider
        Provider::updateOrCreate(
            ['email' => 'support@wizmoto.com'],
            [
                'username' => 'wizmoto-support',
                'first_name' => 'WizMoto',
                'last_name' => 'Support',
                'email' => 'support@wizmoto.com',
                'password' => Hash::make('support123'),
                'phone' => '393517455691',
                'whatsapp' => '00393517455691',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}