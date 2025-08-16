<?php

namespace Database\Seeders;

use App\Models\AdvertisementType;
use App\Models\category;
use App\Models\FuelType;
use Illuminate\Database\Seeder;

class FuelTypeSeeder extends Seeder {
    public function run (): void {

        $scooterCategory = AdvertisementType::where('title', 'Scooter')->first();
        $fuelTypes = [
            ['code' => 'T',  'name' => '2T petrol',       'advertisement_type_id' => $scooterCategory->id],
            ['code' => 'B',  'name' => 'Gas',             'advertisement_type_id' => $scooterCategory->id],
            ['code' => 'D',  'name' => 'Diesel',          'advertisement_type_id' => $scooterCategory->id],
            ['code' => 'L',  'name' => 'LPG',             'advertisement_type_id' => $scooterCategory->id],
            ['code' => '2',  'name' => 'Electric/Petrol', 'advertisement_type_id' => $scooterCategory->id],
            ['code' => 'E',  'name' => 'Electric',        'advertisement_type_id' => $scooterCategory->id],
            ['code' => 'O',  'name' => 'Other',           'advertisement_type_id' => $scooterCategory->id],
        ];

        foreach ($fuelTypes as $type) {
            FuelType::create($type);
        }
    }
}
