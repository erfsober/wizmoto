<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CountriesSeeder extends Seeder
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

        $countries = [];
        foreach (array_keys($data) as $countryName) {
            $countries[] = [
                'name' => $countryName,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('countries')->insert($countries);
        
        $this->command->info('Countries seeded successfully!');
    }
}
