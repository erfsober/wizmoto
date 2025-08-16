<?php

namespace Database\Seeders;

use App\Models\AdvertisementType;
use Illuminate\Database\Seeder;

class AdvertisementTypeSeeder extends Seeder {
    public function run (): void {

        $types = [
            [
                'title' => 'Motor' ,
            ] ,
            [
                'title' => 'Motorbike' ,
            ] ,
            [
                'title' => 'Bicycle' ,
            ] ,
            [
                'title' => 'E.Bike' ,
            ] ,
            [
                'title' => 'Scooter' ,
            ] ,
        ];
        foreach ( $types as $type ) {
            AdvertisementType::query()
                             ->create($type);
        }
    }
}
