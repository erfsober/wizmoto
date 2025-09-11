<?php

namespace Database\Seeders;

use App\Models\AdvertisementType;
use App\Models\FuelType;
use Illuminate\Database\Seeder;

class FuelTypeSeeder extends Seeder
{
    public function run(): void
    {
        // MOTORCYCLES - Fuel types for motorcycles
        $motorcycle = AdvertisementType::where('title', 'Motorcycle')->first();
        $motorcycleFuels = [
            ['code' => 'P',  'name' => 'Petrol/Gasoline'],
            ['code' => 'E',  'name' => 'Electric'],
            ['code' => 'H',  'name' => 'Hybrid (Petrol/Electric)'],
            ['code' => 'D',  'name' => 'Diesel'],
            ['code' => 'L',  'name' => 'LPG'],
            ['code' => 'CNG', 'name' => 'CNG (Compressed Natural Gas)'],
            ['code' => 'ETH', 'name' => 'Ethanol/E85'],
            ['code' => 'O',  'name' => 'Other'],
        ];
        foreach ($motorcycleFuels as $fuel) {
            FuelType::updateOrCreate([
                'code' => $fuel['code'],
                'name' => $fuel['name'],
                'advertisement_type_id' => $motorcycle->id,
            ]);
        }

        // MOTOR SCOOTERS - Fuel types for larger scooters
        $motorScooter = AdvertisementType::where('title', 'Motor Scooter')->first();
        $motorScooterFuels = [
            ['code' => 'P',  'name' => 'Petrol/Gasoline'],
            ['code' => 'E',  'name' => 'Electric'],
            ['code' => 'H',  'name' => 'Hybrid (Petrol/Electric)'],
            ['code' => 'L',  'name' => 'LPG'],
            ['code' => 'CNG', 'name' => 'CNG (Compressed Natural Gas)'],
            ['code' => 'O',  'name' => 'Other'],
        ];
        foreach ($motorScooterFuels as $fuel) {
            FuelType::updateOrCreate([
                'code' => $fuel['code'],
                'name' => $fuel['name'],
                'advertisement_type_id' => $motorScooter->id,
            ]);
        }

        // SCOOTERS - Fuel types for small scooters
        $scooter = AdvertisementType::where('title', 'Scooter')->first();
        $scooterFuels = [
            ['code' => '2T', 'name' => '2-Stroke Petrol'],
            ['code' => '4T', 'name' => '4-Stroke Petrol'],
            ['code' => 'E',  'name' => 'Electric'],
            ['code' => 'H',  'name' => 'Hybrid (Petrol/Electric)'],
            ['code' => 'L',  'name' => 'LPG'],
            ['code' => 'O',  'name' => 'Other'],
        ];
        foreach ($scooterFuels as $fuel) {
            FuelType::updateOrCreate([
                'code' => $fuel['code'],
                'name' => $fuel['name'],
                'advertisement_type_id' => $scooter->id,
            ]);
        }

        // BIKES - Power types for bicycles
        $bike = AdvertisementType::where('title', 'Bike')->first();
        $bikeFuels = [
            ['code' => 'M',  'name' => 'Manual/Pedal'],
            ['code' => 'E',  'name' => 'Electric (E-bike)'],
            ['code' => 'EH', 'name' => 'Electric Hybrid'],
            ['code' => 'O',  'name' => 'Other'],
        ];
        foreach ($bikeFuels as $fuel) {
            FuelType::updateOrCreate([
                'code' => $fuel['code'],
                'name' => $fuel['name'],
                'advertisement_type_id' => $bike->id,
            ]);
        }
    }
}
