<?php

namespace Database\Seeders;

use App\Models\category;
use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{

    public function run(): void
    {
        $scooter = Category::where('name', 'Scooter')->first();

        $brands = [
            'Piaggio',
            'Yamaha',
            'Vespa',
            'Honda',
        ];

        foreach ($brands as $title) {
            Brand::updateOrCreate([
                                      'name' => $title,
                                      'category_id' => $scooter->id,
                                  ]);
        }
    }
}
