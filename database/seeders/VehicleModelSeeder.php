<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\VehicleModel;
use Illuminate\Database\Seeder;

/**
 * Vehicle Model Seeder
 * 
 * Organizes vehicle models by brand
 * Models are listed under their respective brand names
 * 
 * To add a new model:
 * 1. Find the brand name in the array
 * 2. Add the model name to that brand's array
 * 3. Run: php artisan db:seed --class=VehicleModelSeeder
 * 
 * Note: If a brand exists in multiple categories (e.g., Yamaha for both Motorcycles and Scooters),
 * the models will be added to ALL instances of that brand.
 */
class VehicleModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brandsWithModels = $this->getModelsData();

        foreach ($brandsWithModels as $brandName => $models) {
            // Get the brand (now there's only one per name!)
            $brand = Brand::where('name', $brandName)->first();

            if (!$brand) {
                $this->command->warn("Brand '{$brandName}' not found. Skipping models.");
                continue;
            }

            $createdCount = 0;
            foreach ($models as $modelName) {
                // Skip empty entries
                if (empty(trim($modelName))) {
                    continue;
                }

                VehicleModel::updateOrCreate(
                    [
                        'brand_id' => $brand->id,
                        'name' => trim($modelName),
                    ],
                    [
                        'name' => trim($modelName),
                    ]
                );
                $createdCount++;
            }
            
            if ($createdCount > 0) {
                $this->command->info("✓ Seeded {$createdCount} models for {$brandName} (ID: {$brand->id})");
            }
        }
    }

    /**
     * Get all models organized by brand
     * 
     * @return array<string, array<string>>
     */
    private function getModelsData(): array
    {
        return [
            // ============================================
            // MOTORCYCLE MODELS
            // ============================================
            
            'Aprilia' => [
                'Dorsoduro 900',
                'RS 660',
                'RSV4',
                'Shiver 900',
                'SR GT',
                'SRV 850',
                'Tuareg 660',
                'Tuono 660',
                'Tuono V4 1100',
            ],

            'BMW' => [
                'C 400 GT',
                'C 400 X',
                'CE 04',
                'F 750 GS',
                'F 850 GS',
                'F 900 R',
                'F 900 XR',
                'G 310 GS',
                'G 310 R',
                'K 1600 B',
                'K 1600 GT',
                'K 1600 GTL',
                'M 1000 RR',
                'R 1250 GS',
                'R 1250 GS Adventure',
                'R 1250 R',
                'R 1250 RS',
                'R 1250 RT',
                'R 18',
                'R 18 Classic',
                'R nineT',
                'S 1000 R',
                'S 1000 RR',
                'S 1000 XR',
            ],

            'Ducati' => [
                'Diavel 1260',
                'Diavel V4',
                'Hypermotard 950',
                'Monster',
                'Monster 821',
                'Monster 937',
                'Monster 1200',
                'Multistrada 950',
                'Multistrada V2',
                'Multistrada V4',
                'Panigale V2',
                'Panigale V4',
                'Scrambler Sixty2',
                'Scrambler 800',
                'Scrambler 1100',
                'Scrambler Icon',
                'Scrambler Desert Sled',
                'DesertX',
                'Streetfighter V2',
                'Streetfighter V4',
                'SuperSport 950',
            ],

            'Harley-Davidson' => [
                'Breakout',
                'CVO Limited',
                'CVO Road Glide',
                'CVO Street Glide',
                'Electra Glide',
                'Fat Bob',
                'Fat Boy',
                'Forty-Eight',
                'Heritage Classic',
                'Iron 883',
                'Iron 1200',
                'LiveWire',
                'Low Rider',
                'Low Rider S',
                'Nightster',
                'Pan America 1250',
                'Road Glide',
                'Road King',
                'Softail Slim',
                'Sport Glide',
                'Sportster S',
                'Street Bob',
                'Street Glide',
                'Ultra Limited',
            ],

            'Honda' => [
                'Africa Twin',
                'CB125R',
                'CB300R',
                'CB500F',
                'CB500X',
                'CB650F',
                'CB650R',
                'CB1000R',
                'CBR125R',
                'CBR500R',
                'CBR600RR',
                'CBR650R',
                'CBR1000RR',
                'CBR1000RR-R Fireblade',
                'CMX500 Rebel',
                'CMX1100 Rebel',
                'CRF250L',
                'CRF300L',
                'CRF450L',
                'CRF1100L Africa Twin',
                'Forza 125',
                'Forza 350',
                'Forza 750',
                'Gold Wing',
                'Grom',
                'Monkey',
                'NC750X',
                'PCX 125',
                'PCX 160',
                'SH125i',
                'SH150i',
                'SH300i',
                'SH350i',
                'Shadow 750',
                'VFR800F',
                'X-ADV 750',
            ],

            'Kawasaki' => [
                'Ninja 125',
                'Ninja 400',
                'Ninja 650',
                'Ninja 1000SX',
                'Ninja H2',
                'Ninja H2 SX',
                'Ninja ZX-6R',
                'Ninja ZX-10R',
                'Ninja ZX-10RR',
                'Versys 650',
                'Versys 1000',
                'Vulcan S',
                'Vulcan 900',
                'W800',
                'Z125',
                'Z400',
                'Z650',
                'Z900',
                'Z900RS',
                'Z1000',
                'Z H2',
            ],

            'KTM' => [
                '125 Duke',
                '200 Duke',
                '250 Duke',
                '390 Duke',
                '690 Duke',
                '790 Duke',
                '890 Duke',
                '890 Duke R',
                '1290 Super Duke R',
                '1290 Super Duke GT',
                '390 Adventure',
                '790 Adventure',
                '890 Adventure',
                '890 Adventure R',
                '1290 Super Adventure S',
                '1290 Super Adventure R',
                'RC 125',
                'RC 200',
                'RC 390',
                '690 Enduro R',
                '690 SMC R',
            ],

            'Suzuki' => [
                'Address 110',
                'Bandit 650',
                'Bandit 1250',
                'Boulevard M50',
                'Boulevard M109R',
                'Burgman 125',
                'Burgman 200',
                'Burgman 400',
                'DR-Z400SM',
                'GSX-8S',
                'GSX-R125',
                'GSX-R600',
                'GSX-R750',
                'GSX-R1000',
                'GSX-S125',
                'GSX-S750',
                'GSX-S1000',
                'Hayabusa',
                'Intruder M800',
                'Katana',
                'SV650',
                'SV650X',
                'V-Strom 650',
                'V-Strom 1050',
            ],

            'Triumph' => [
                'Bonneville Bobber',
                'Bonneville Speedmaster',
                'Bonneville T100',
                'Bonneville T120',
                'Daytona 660',
                'Daytona Moto2 765',
                'Rocket 3',
                'Rocket 3 GT',
                'Rocket 3 R',
                'Scrambler 900',
                'Scrambler 1200',
                'Speed Triple 1200 RS',
                'Speed Triple 1200 RR',
                'Speed Twin',
                'Street Scrambler',
                'Street Triple',
                'Street Triple R',
                'Street Triple RS',
                'Thruxton RS',
                'Tiger 660 Sport',
                'Tiger 850 Sport',
                'Tiger 900',
                'Tiger 900 GT',
                'Tiger 900 Rally',
                'Tiger 1200',
                'Trident 660',
            ],

            'Yamaha' => [
                'Aerox 155',
                'D\'elight 125',
                'FJR1300',
                'FZ6',
                'Majesty S 125',
                'MT-03',
                'MT-07',
                'MT-09',
                'MT-09 SP',
                'MT-10',
                'MT-10 SP',
                'MT-125',
                'NMAX 125',
                'NMAX 155',
                'R1',
                'R1M',
                'R3',
                'R6',
                'R7',
                'SCR950',
                'Super Ténéré',
                'TMAX',
                'TMAX 560',
                'TMAX 560 Tech MAX',
                'Tracer 7',
                'Tracer 9',
                'Tracer 9 GT',
                'Tricity 125',
                'Tricity 300',
                'TW200',
                'V-MAX',
                'XJ6',
                'XSR700',
                'XSR900',
                'XSR900 GP',
                'YZF-R1',
                'YZF-R1M',
                'YZF-R3',
                'YZF-R6',
                'YZF-R7',
                'YZF-R125',
            ],

            'Royal Enfield' => [
                'Bullet 350',
                'Bullet 500',
                'Classic 350',
                'Classic 500',
                'Continental GT 650',
                'Himalayan',
                'Hunter 350',
                'Interceptor 650',
                'Meteor 350',
                'Scram 411',
            ],

            'Indian Motorcycle' => [
                'Chief',
                'Chief Bobber',
                'Chief Dark Horse',
                'Chieftain',
                'FTR 1200',
                'FTR Rally',
                'FTR Sport',
                'Pursuit',
                'Roadmaster',
                'Scout',
                'Scout Bobber',
                'Scout Rogue',
                'Springfield',
            ],

            'Moto Guzzi' => [
                'Audace',
                'California 1400',
                'Eldorado',
                'MGX-21',
                'V7 III',
                'V7 Stone',
                'V7 Special',
                'V9 Bobber',
                'V9 Roamer',
                'V85 TT',
                'V100 Mandello',
            ],

            'MV Agusta' => [
                'Brutale 800',
                'Brutale 1000',
                'Dragster 800',
                'F3 800',
                'F4',
                'Rush 1000',
                'Superveloce 800',
                'Turismo Veloce',
            ],

            // ============================================
            // SCOOTER MODELS
            // ============================================

            'Piaggio' => [
                'Beverly 300',
                'Beverly 350',
                'Beverly 400',
                'Fly 50',
                'Fly 125',
                'Liberty 50',
                'Liberty 125',
                'Liberty 150',
                'Medley 125',
                'Medley 150',
                'MP3 300',
                'MP3 400',
                'MP3 500',
                'Typhoon 50',
                'Typhoon 125',
                'Zip 50',
                'Zip 100',
            ],

            'Vespa' => [
                'Elettrica',
                'GTS 125',
                'GTS 300',
                'GTS Super 300',
                'GTS Super Sport 300',
                'GTS Super Tech 300',
                'GTV 300',
                'LX 50',
                'LX 125',
                'LX 150',
                'Primavera 50',
                'Primavera 125',
                'Primavera 150',
                'Sprint 50',
                'Sprint 125',
                'Sprint 150',
            ],

            'Kymco' => [
                'Agility 50',
                'Agility 125',
                'AK 550',
                'Downtown 125i',
                'Downtown 300i',
                'Downtown 350i',
                'Grand Dink 125',
                'Grand Dink 300',
                'Like 50',
                'Like 125',
                'Like 150i',
                'People S 125',
                'People S 200',
                'People S 300',
                'Super 8 50',
                'Super 8 125',
                'Xciting 400',
                'Xciting S 400',
            ],

            'SYM' => [
                'Citycom 300',
                'Fiddle II 50',
                'Fiddle III 125',
                'Joymax Z 300',
                'Maxsym 400',
                'Maxsym TL 500',
                'Mio 100',
                'Mio 115',
                'Orbit II 125',
                'Orbit III 125',
                'Symphony SR 125',
                'Symphony ST 125',
            ],

            // ============================================
            // BICYCLE MODELS
            // ============================================

            'Trek' => [
                'Domane AL 2',
                'Domane AL 5',
                'Domane SL 5',
                'Domane SL 7',
                'Domane SLR 9',
                'Dual Sport 1',
                'Dual Sport 2',
                'Dual Sport 3',
                'Emonda ALR 4',
                'Emonda ALR 5',
                'Emonda SL 5',
                'Emonda SL 6',
                'Emonda SLR 7',
                'FX 1',
                'FX 2',
                'FX 3',
                'Fuel EX 5',
                'Fuel EX 7',
                'Fuel EX 9.8',
                'Marlin 5',
                'Marlin 6',
                'Marlin 7',
                'Powerfly 4',
                'Powerfly 5',
                'Rail 9.7',
                'Rail 9.8',
                'Slash 8',
                'Slash 9.8',
                'Top Fuel 9.8',
                'Verve 2',
                'Verve 3',
                'Verve+ 2',
                'X-Caliber 7',
                'X-Caliber 8',
            ],

            'Giant' => [
                'Anthem 29',
                'Contend 1',
                'Contend 2',
                'Contend 3',
                'Defy Advanced 0',
                'Defy Advanced 1',
                'Defy Advanced 2',
                'Escape 3',
                'Explore E+ 1',
                'Explore E+ 2',
                'Fathom 1',
                'Fathom 2',
                'Quick-E+ 25',
                'Quick-E+ 45',
                'Reign 29',
                'Revolt Advanced 1',
                'Revolt Advanced 2',
                'Roam 2',
                'Roam 3',
                'Stance 29',
                'Talon 29',
                'TCR Advanced 0',
                'TCR Advanced 1',
                'TCR Advanced Pro 0',
                'Toughroad SLR 2',
                'Trance 29',
                'Trance X 29',
                'XTC Advanced 29',
            ],

            'Specialized' => [
                'Allez',
                'Allez Elite',
                'Allez Sprint',
                'Chisel',
                'Como 3.0',
                'Como 4.0',
                'Como 5.0',
                'Creo SL',
                'Diverge',
                'Diverge Elite E5',
                'Epic',
                'Epic EVO',
                'Levo',
                'Levo SL',
                'Kenevo',
                'Rockhopper',
                'Rockhopper Elite',
                'Roubaix',
                'Roubaix Sport',
                'Sirrus 2.0',
                'Sirrus X 3.0',
                'Sirrus X 4.0',
                'Stumpjumper',
                'Stumpjumper EVO',
                'Tarmac',
                'Tarmac SL7',
                'Turbo Creo',
                'Turbo Levo',
                'Turbo Vado',
                'Vado 4.0',
                'Vado 5.0',
            ],

            'Cannondale' => [
                'Adventure EQ',
                'CAAD13',
                'CAAD Optimo',
                'Habit',
                'Jekyll',
                'Moterra NEO',
                'Quick CX 3',
                'Quick CX 4',
                'Scalpel',
                'Scalpel-Si',
                'SuperSix EVO',
                'Synapse',
                'Synapse Carbon',
                'SystemSix',
                'Topstone',
                'Topstone Carbon',
                'Trail',
                'Trigger',
            ],

            'Scott' => [
                'Addict RC',
                'Aspect 760',
                'Aspect 950',
                'Contessa Scale 910',
                'E-Silence EVO',
                'Genius 960',
                'Plasma',
                'Scale 970',
                'Scale 980',
                'Spark 960',
                'Spark 970',
                'Speedster 10',
                'Speedster 20',
                'Strike eRIDE 920',
                'Strike eRIDE 930',
                'Sub Cross 10',
                'Sub Cross 20',
                'Sub Cross 50',
            ],

            // Add new brand models below
            // Format:
            // 'Brand Name' => [
            //     'Model 1',
            //     'Model 2',
            //     'Model 3',
            // ],
        ];
    }
}
