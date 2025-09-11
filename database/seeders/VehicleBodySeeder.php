<?php

namespace Database\Seeders;

use App\Models\AdvertisementType;
use App\Models\VehicleBody;
use Illuminate\Database\Seeder;

class VehicleBodySeeder extends Seeder
{
    public function run(): void
    {
        // MOTORCYCLES - Body types for motorcycles
        $motorcycle = AdvertisementType::where('title', 'Motorcycle')->first();
        $motorcycleBodies = [
            'Sport/Supersport',
            'Naked/Roadster',
            'Cruiser/Chopper',
            'Touring/Sport Touring',
            'Enduro/Adventure',
            'Cross/Motocross',
            'Trial',
            'Supermotard',
            'Streetfighter',
            'Cafe Racer',
            'Bobber',
            'Custom',
            'Classic/Vintage',
            'Other'
        ];
        foreach ($motorcycleBodies as $body) {
            VehicleBody::updateOrCreate([
                'name' => $body,
                'advertisement_type_id' => $motorcycle->id,
            ]);
        }

        // MOTOR SCOOTERS - Larger scooters body types
        $motorScooter = AdvertisementType::where('title', 'Motor Scooter')->first();
        $motorScooterBodies = [
            'Maxi Scooter',
            'Sport Scooter',
            'Touring Scooter',
            'Urban Scooter',
            'Retro Scooter',
            'Adventure Scooter',
            'Three-Wheeler',
            'Other'
        ];
        foreach ($motorScooterBodies as $body) {
            VehicleBody::updateOrCreate([
                'name' => $body,
                'advertisement_type_id' => $motorScooter->id,
            ]);
        }

        // SCOOTERS - Small scooters body types
        $scooter = AdvertisementType::where('title', 'Scooter')->first();
        $scooterBodies = [
            'Classic Scooter',
            'Modern Scooter',
            'Retro Scooter',
            'Sport Scooter',
            'Moped',
            'Electric Scooter',
            'Kick Scooter',
            'Other'
        ];
        foreach ($scooterBodies as $body) {
            VehicleBody::updateOrCreate([
                'name' => $body,
                'advertisement_type_id' => $scooter->id,
            ]);
        }

        // BIKES - Bicycle body types
        $bike = AdvertisementType::where('title', 'Bike')->first();
        $bikeBodies = [
            'Road Bike',
            'Mountain Bike',
            'Hybrid Bike',
            'City Bike',
            'Electric Bike (E-bike)',
            'BMX',
            'Cruiser Bike',
            'Touring Bike',
            'Gravel Bike',
            'Cyclocross',
            'Folding Bike',
            'Fat Bike',
            'Cargo Bike',
            'Kids Bike',
            'Other'
        ];
        foreach ($bikeBodies as $body) {
            VehicleBody::updateOrCreate([
                'name' => $body,
                'advertisement_type_id' => $bike->id,
            ]);
        }
    }
}
