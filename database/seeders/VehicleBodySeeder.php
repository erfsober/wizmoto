<?php

namespace Database\Seeders;

use App\Models\AdvertisementType;
use App\Models\category;
use App\Models\VehicleBody;
use Illuminate\Database\Seeder;

class VehicleBodySeeder extends Seeder {
    public function run (): void {
        $scooterCategory = AdvertisementType::where('title', 'Scooter')->first();
        $bodies = [
            'Chopper/Cruiser' ,
            'Mopeds' ,
            'Cross' ,
            'Enduro' ,
            'Road Enduro' ,
            'Era' ,
            'Minimoto' ,
            'Naked' ,
            'Quad/ATV' ,
            'Racing' ,
            'Rally' ,
            'Scooter' ,
            'Sidecar' ,
            'Sport touring' ,
            'Streetfighter' ,
            'Super sports cars' ,
            'Supermotard' ,
            'Tourer' ,
            'Trial' ,
            'Trike' ,
            'Other' ,
        ];
        foreach ( $bodies as $body ) {
            VehicleBody::query()
                       ->create([
                                    'name' => $body ,
                                    'advertisement_type_id' => $scooterCategory->id,
                                ]);
        }
    }
}
