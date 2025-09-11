<?php

namespace Database\Seeders;

use App\Models\AdvertisementType;
use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        // MOTORCYCLES - High-performance & touring bikes
        $motorcycle = AdvertisementType::where('title', 'Motorcycle')->first();
        $motorcycleBrands = [
            'Yamaha',
            'Honda',
            'Kawasaki',
            'Suzuki',
            'BMW',
            'Ducati',
            'KTM',
            'Triumph',
            'Harley-Davidson',
            'Indian Motorcycle',
            'Aprilia',
            'Moto Guzzi',
            'Royal Enfield',
            'Norton',
            'MV Agusta',
            'Benelli'
        ];
        foreach ($motorcycleBrands as $brand) {
            Brand::updateOrCreate([
                'name' => $brand,
                'advertisement_type_id' => $motorcycle->id,
            ]);
        }

        // MOTOR SCOOTERS - Larger scooters (125cc+)
        $motorScooter = AdvertisementType::where('title', 'Motor Scooter')->first();
        $motorScooterBrands = [
            'Yamaha',
            'Honda',
            'Piaggio',
            'Vespa',
            'Suzuki',
            'Kymco',
            'SYM',
            'Aprilia',
            'Gilera',
            'Peugeot',
            'Malaguti',
            'MBK',
            'Benelli',
            'CFMoto'
        ];
        foreach ($motorScooterBrands as $brand) {
            Brand::updateOrCreate([
                'name' => $brand,
                'advertisement_type_id' => $motorScooter->id,
            ]);
        }

        // SCOOTERS - Small scooters (50cc-125cc)
        $scooter = AdvertisementType::where('title', 'Scooter')->first();
        $scooterBrands = [
            'Piaggio',
            'Vespa',
            'Yamaha',
            'Honda',
            'Peugeot',
            'Kymco',
            'SYM',
            'MBK',
            'Derbi',
            'Gilera',
            'Aprilia',
            'Malaguti',
            'Generic',
            'Keeway',
            'Baotian',
            'TGB'
        ];
        foreach ($scooterBrands as $brand) {
            Brand::updateOrCreate([
                'name' => $brand,
                'advertisement_type_id' => $scooter->id,
            ]);
        }

        // BIKES - Bicycles (pedal bikes)
        $bike = AdvertisementType::where('title', 'Bike')->first();
        $bikeBrands = [
            'Trek',
            'Giant',
            'Specialized',
            'Cannondale',
            'Scott',
            'Merida',
            'Cube',
            'Bianchi',
            'Canyon',
            'Rose',
            'Focus',
            'KTM',
            'Haibike',
            'Bulls',
            'Kalkhoff',
            'Gazelle',
            'Bosch',
            'Shimano',
            'Cervelo',
            'Pinarello'
        ];
        foreach ($bikeBrands as $brand) {
            Brand::updateOrCreate([
                'name' => $brand,
                'advertisement_type_id' => $bike->id,
            ]);
        }
    }
}
