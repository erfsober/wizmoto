<?php

namespace Database\Seeders;

use App\Models\Equipment;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder {
    public function run (): void {
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
            Equipment::updateOrCreate([ 'title' => $item ] , [
                                                               'created_at' => now() ,
                                                               'updated_at' => now(),
                                                           ]);
        }
    }
}
