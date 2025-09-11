<?php

namespace Database\Seeders;

use App\Models\AdvertisementType;
use App\Models\Equipment;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    public function run(): void
    {
        // MOTORCYCLES - High-performance & touring equipment
        $motorcycle = AdvertisementType::where('title', 'Motorcycle')->first();
        $motorcycleEquipment = [
            // Safety & Protection
            'ABS (Anti-lock Braking System)',
            'Traction Control',
            'Wheelie Control',
            'Cornering ABS',
            'Crash Bars/Engine Guards',
            'Frame Sliders',
            'Tank Pads',
            'Knee Pads',

            // Performance & Engine
            'Quick Shifter',
            'Slipper Clutch',
            'Power Modes',
            'Launch Control',
            'Cruise Control',
            'Engine Braking Control',
            'Exhaust System (Aftermarket)',
            'Air Filter (High-Flow)',

            // Electronics & Navigation
            'TFT Display',
            'GPS Navigation',
            'Bluetooth Connectivity',
            'USB Charger/Phone Mount',
            'Heated Grips',
            'Tire Pressure Monitoring',
            'Keyless Ignition',
            'Alarm System',

            // Comfort & Touring
            'Windshield/Windscreen',
            'Top Box',
            'Side Cases/Panniers',
            'Tank Bag',
            'Seat Heating',
            'Adjustable Suspension',
            'Center Stand',
            'Side Stand',

            // Lighting & Visibility
            'LED Headlight',
            'LED Tail Light',
            'Turn Signal Indicators',
            'Auxiliary Lights',
            'Daytime Running Lights',

            // Accessories
            'Motorcycle Cover',
            'Chain Guard',
            'Anti-Theft Lock',
            'Tool Kit',
            'First Aid Kit',
        ];

        foreach ($motorcycleEquipment as $item) {
            Equipment::updateOrCreate([
                'name' => $item,
                'advertisement_type_id' => $motorcycle->id
            ]);
        }

        // MOTOR SCOOTERS - Larger scooters (125cc+) equipment
        $motorScooter = AdvertisementType::where('title', 'Motor Scooter')->first();
        $motorScooterEquipment = [
            // Safety Features
            'ABS (Anti-lock Braking System)',
            'Combined Braking System',
            'Traction Control',
            'Anti-Theft Alarm',
            'Immobilizer',
            'Smart Key System',

            // Storage & Practicality
            'Under-Seat Storage',
            'Top Box',
            'Front Storage/Glove Box',
            'Side Storage Compartments',
            'Cargo Rack',
            'Shopping Hook',

            // Comfort & Convenience
            'Windshield/Wind Deflector',
            'Heated Grips',
            'Heated Seat',
            'Adjustable Seat',
            'Floor Mat',
            'Leg Covers/Apron',

            // Electronics
            'Digital Display',
            'GPS Navigation',
            'Bluetooth Connectivity',
            'USB Charging Port',
            '12V Power Outlet',
            'Phone Holder',

            // Performance
            'CVT Transmission',
            'Fuel Injection',
            'Catalytic Converter',
            'Variable Valve Timing',

            // Lighting
            'LED Headlight',
            'LED Tail Light',
            'Turn Signals',
            'Hazard Lights',
            'Position Lights',

            // Accessories
            'Scooter Cover',
            'Center Stand',
            'Side Stand',
            'Tool Kit',
            'Spare Tire',
        ];

        foreach ($motorScooterEquipment as $item) {
            Equipment::updateOrCreate([
                'name' => $item,
                'advertisement_type_id' => $motorScooter->id
            ]);
        }

        // SCOOTERS - Small scooters (50cc-125cc) equipment
        $scooter = AdvertisementType::where('title', 'Scooter')->first();
        $scooterEquipment = [
            // Basic Safety
            'Helmet Storage',
            'Anti-Theft Lock',
            'Alarm System',
            'Side Stand',
            'Center Stand',
            'Rear View Mirrors',

            // Storage Solutions
            'Under-Seat Storage',
            'Front Basket',
            'Top Box',
            'Side Box',
            'Cargo Net',
            'Shopping Hook',

            // Comfort Features
            'Windshield',
            'Heated Grips',
            'Cushioned Seat',
            'Floor Mat',
            'Leg Shield',
            'Weather Protection',

            // Electronics & Charging
            'USB Charger',
            'Phone Mount',
            'Digital Speedometer',
            'Fuel Gauge',
            'Battery Indicator',
            '12V Socket',

            // Lighting & Visibility
            'LED Headlight',
            'LED Tail Light',
            'Turn Signal Indicators',
            'Brake Light',
            'Position Lights',
            'Reflectors',

            // Engine & Performance
            'Electric Start',
            'Kick Start',
            'Automatic Transmission',
            'Fuel Injection',
            'Air Filter',

            // Accessories
            'Scooter Cover',
            'Rain Cover',
            'Tool Kit',
            'Spare Key',
            'Owner Manual',
            'Service Record',
        ];

        foreach ($scooterEquipment as $item) {
            Equipment::updateOrCreate([
                'name' => $item,
                'advertisement_type_id' => $scooter->id
            ]);
        }

        // BIKES - Bicycle equipment
        $bike = AdvertisementType::where('title', 'Bike')->first();
        $bikeEquipment = [
            // Safety & Protection
            'Helmet',
            'Knee Pads',
            'Elbow Pads',
            'Reflective Vest',
            'Safety Lights',
            'Bell/Horn',
            'Reflectors',

            // Lighting Systems
            'Front Light/Headlight',
            'Rear Light/Tail Light',
            'LED Light Set',
            'Rechargeable Lights',
            'Solar Powered Lights',
            'Wheel Lights',

            // Storage & Carrying
            'Front Basket',
            'Rear Rack',
            'Pannier Bags',
            'Frame Bag',
            'Saddle Bag',
            'Water Bottle Holder',
            'Phone Mount',

            // Performance & Components
            'Speedometer/Computer',
            'GPS Device',
            'Heart Rate Monitor',
            'Cadence Sensor',
            'Power Meter',
            'Suspension Fork',

            // Comfort & Ergonomics
            'Comfortable Saddle',
            'Ergonomic Grips',
            'Adjustable Stem',
            'Seat Post',
            'Suspension Seat Post',
            'Handlebar Extensions',

            // Security
            'Chain Lock',
            'U-Lock',
            'Cable Lock',
            'Alarm System',
            'GPS Tracker',
            'Quick Release Wheels',

            // Maintenance Tools
            'Multi-Tool',
            'Tire Pump',
            'Spare Tubes',
            'Patch Kit',
            'Chain Lubricant',
            'Tire Levers',

            // Weather Protection
            'Mudguards/Fenders',
            'Chain Guard',
            'Bike Cover',
            'Rain Gear',
            'Handlebar Mitts',

            // Electric Bike Specific
            'Battery Pack',
            'Charger',
            'Display Unit',
            'Throttle',
            'Pedal Assist Sensor',
            'Motor Controller',

            // Accessories
            'Kickstand',
            'Training Wheels',
            'Child Seat',
            'Trailer Hitch',
            'Cargo Trailer',
            'Bike Maintenance Stand',
        ];

        foreach ($bikeEquipment as $item) {
            Equipment::updateOrCreate([
                'name' => $item,
                'advertisement_type_id' => $bike->id
            ]);
        }
    }
}
