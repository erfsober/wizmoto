<?php

namespace Database\Seeders;

use App\Models\AdvertisementType;
use App\Models\category;
use App\Models\Equipment;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder {
    public function run (): void {
        $scooterCategory = AdvertisementType::where('title', 'Scooter')->first();

        $equipmentItems = [
            'Helmet' ,
            'ABS' ,
            'Top Box' ,
            'USB Charger' ,
            'GPS' ,
            'Windshield' ,
            'Heated Grips' ,
            'Alarm System' ,
            'Crash Bars' ,
            'Side Stand' ,
            'Center Stand' ,
            'LED Headlight' ,
            'Scooter Cover' ,
            'Anti-Theft Lock' ,
            'Bluetooth Connectivity' ,
        ];
        foreach ( $equipmentItems as $item ) {
            Equipment::updateOrCreate([ 'name' => $item ,'advertisement_type_id'=>$scooterCategory->id]);
        }
    }
}
