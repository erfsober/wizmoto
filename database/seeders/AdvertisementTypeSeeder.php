<?php

namespace Database\Seeders;

use App\Models\AdvertisementType;
use Illuminate\Database\Seeder;

class AdvertisementTypeSeeder extends Seeder {
    public function run (): void {

        $types = [
            [
                'title' => 'Motor Scooter' ,
            ] ,
            [
                'title' => 'Motorcycle' ,
            ] ,
        
            [
                'title' => 'Scooter' ,
            ] ,
            [
                'title' => 'Bike' ,
            ] ,
           
        ];
        foreach ( $types as $type ) {
            AdvertisementType::query()
                             ->create($type);
        }
    }
}
