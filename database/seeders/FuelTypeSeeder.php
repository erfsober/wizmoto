<?php

namespace Database\Seeders;

use App\Models\category;
use App\Models\FuelType;
use Illuminate\Database\Seeder;

class FuelTypeSeeder extends Seeder {
    public function run (): void {

        $scooterCategory = Category::where('name', 'Scooter')->first();
        $fuelTypes = [
            ['code' => 'T',  'name' => '2T petrol',       'category_id' => $scooterCategory->id],
            ['code' => 'B',  'name' => 'Gas',             'category_id' => $scooterCategory->id],
            ['code' => 'D',  'name' => 'Diesel',          'category_id' => $scooterCategory->id],
            ['code' => 'L',  'name' => 'LPG',             'category_id' => $scooterCategory->id],
            ['code' => '2',  'name' => 'Electric/Petrol', 'category_id' => $scooterCategory->id],
            ['code' => 'E',  'name' => 'Electric',        'category_id' => $scooterCategory->id],
            ['code' => 'O',  'name' => 'Other',           'category_id' => $scooterCategory->id],
        ];

        foreach ($fuelTypes as $type) {
            FuelType::create($type);
        }
    }
}
