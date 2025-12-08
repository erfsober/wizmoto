<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    public function run (): void {
        $this->call([
                        AdvertisementTypeSeeder::class ,
                        BrandSeeder::class ,
                        VehicleModelSeeder::class ,
                        EquipmentSeeder::class ,
                        // VehicleBodySeeder::class ,
                        // VehicleColorSeeder::class ,
                        // FuelTypeSeeder::class ,
                        BlogCategorySeeder::class,
                        BlogPostSeeder::class,
                        AboutUsSeeder::class,
                        FaqSeeder::class,
                        SupporterSeeder::class,
                        SettingsSeeder::class,
                        AdminSeeder::class,
                        CountriesSeeder::class,
                        CitiesSeeder::class,
                        PopulateAllItalianTranslationsSeeder::class,
                    ]);
    }
}
