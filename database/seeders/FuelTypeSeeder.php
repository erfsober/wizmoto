<?php

namespace Database\Seeders;

use App\Models\FuelType;
use Illuminate\Database\Seeder;

/**
 * Fuel Type Seeder
 * 
 * Creates universal fuel/power types that apply to ALL vehicle categories
 * No more duplicates - each fuel type exists only once!
 * 
 * To add a new fuel type:
 * 1. Add it to the getFuelTypesData() method
 * 2. Run: php artisan db:seed --class=FuelTypeSeeder
 * 
 * Examples:
 * - 'Petrol' works for motorcycles, scooters, bikes with motors
 * - 'Electric' works for e-bikes, electric scooters, electric motorcycles
 * - 'Manual' only for bicycles
 */
class FuelTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing fuel types
        FuelType::truncate();
        
        $fuelTypes = $this->getFuelTypesData();

        foreach ($fuelTypes as $fuelType) {
            // Skip empty or invalid entries
            if (empty(trim($fuelType['code'] ?? '')) || empty(trim($fuelType['name'] ?? ''))) {
                continue;
            }

            FuelType::create([
                'code' => trim($fuelType['code']),
                'name' => trim($fuelType['name']),
            ]);
        }

        $count = count($fuelTypes);
        $this->command->info("✓ Seeded {$count} unique fuel types");
    }

    /**
     * Get all fuel/power types
     * 
     * Format: ['code' => 'SHORT_CODE', 'name' => 'Display Name']
     * 
     * @return array<array{code: string, name: string}>
     */
    private function getFuelTypesData(): array
    {
        return [
            // ============================================
            // COMMON FUEL TYPES (Motorcycles & Scooters)
            // ============================================
            
            ['code' => 'P',     'name' => 'Petrol'],
            ['code' => 'D',     'name' => 'Diesel'],
            ['code' => 'E',     'name' => 'Electric'],
            ['code' => 'HYB',   'name' => 'Hybrid (Petrol/Electric)'],
            
            // ============================================
            // ALTERNATIVE FUELS
            // ============================================
            
            ['code' => 'LPG',   'name' => 'LPG (Liquefied Petroleum Gas)'],
            ['code' => 'CNG',   'name' => 'CNG (Compressed Natural Gas)'],
            ['code' => 'ETH',   'name' => 'Ethanol/E85'],
            ['code' => 'H2',    'name' => 'Hydrogen'],
            
            // ============================================
            // SCOOTER SPECIFIC
            // ============================================
            
            ['code' => '2T',    'name' => '2-Stroke Petrol'],
            ['code' => '4T',    'name' => '4-Stroke Petrol'],
            
            // ============================================
            // BICYCLE SPECIFIC (Pedal Power)
            // ============================================
            
            ['code' => 'M',     'name' => 'Manual (Pedal Power)'],
            ['code' => 'PE',    'name' => 'Pedelec (Pedal Assist)'],
            ['code' => 'SB',    'name' => 'Speed E-Bike (S-Pedelec)'],
            ['code' => 'EH',    'name' => 'Electric Hybrid'],
            
            // ============================================
            // OTHER
            // ============================================
            
            ['code' => 'OTH',   'name' => 'Other'],
            
            // ============================================
            // ADD NEW FUEL TYPES BELOW
            // Format: ['code' => 'CODE', 'name' => 'Display Name'],
            // ============================================
            
        ];
    }
}
