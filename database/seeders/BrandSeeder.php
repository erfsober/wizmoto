<?php

namespace Database\Seeders;

use App\Models\AdvertisementType;
use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{

    public function run(): void
    {
        $scooter = AdvertisementType::where('title', 'Scooter')->first();

        $brands = [
            'Piaggio',
            'Yamaha',
            'Vespa',
            'Honda',
        ];

        foreach ($brands as $title) {
            Brand::updateOrCreate([
                                      'name' => $title,
                                      'advertisement_type_id' => $scooter->id,
                                  ]);
        }
    }
}
