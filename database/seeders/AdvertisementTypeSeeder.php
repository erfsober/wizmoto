<?php

namespace Database\Seeders;

use App\Models\AdvertisementType;
use Illuminate\Database\Seeder;

class AdvertisementTypeSeeder extends Seeder {
    public function run (): void {

        $types = [
            [
                'title' => 'Scooter' ,
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
                'title' => 'Monopattino' ,
            ] ,
        ];
        foreach ( $types as $type ) {
            AdvertisementType::query()
                             ->create($type);
        }
    }
}
