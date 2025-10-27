<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = database_path('countries_cities.json');
        
        if (!File::exists($jsonPath)) {
            $this->command->error('countries_cities.json file not found!');
            return;
        }

        $data = json_decode(File::get($jsonPath), true);

        if (!$data) {
            $this->command->error('Failed to parse JSON file!');
            return;
        }

        // Get all countries with their IDs
        $countries = DB::table('countries')->pluck('id', 'name')->toArray();

        $cities = [];
        $batchSize = 1000;
        $count = 0;

        foreach ($data as $countryName => $cityList) {
            if (!isset($countries[$countryName])) {
                continue;
            }

            $countryId = $countries[$countryName];

            foreach ($cityList as $cityName) {
                $cities[] = [
                    'country_id' => $countryId,
                    'name' => $cityName,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $count++;

                // Insert in batches to avoid memory issues
                if ($count >= $batchSize) {
                    DB::table('cities')->insert($cities);
                    $cities = [];
                    $count = 0;
                }
            }
        }

        // Insert remaining cities
        if (!empty($cities)) {
            DB::table('cities')->insert($cities);
        }

        $this->command->info('Cities seeded successfully!');
    }
}
