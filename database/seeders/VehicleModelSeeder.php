<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\VehicleModel;
use Illuminate\Database\Seeder;

class VehicleModelSeeder extends Seeder
{
    public function run(): void
    {
        $brandsWithModels = [
            // MOTORCYCLE MODELS
            'Yamaha' => [
                'YZF-R1',
                'YZF-R6',
                'MT-07',
                'MT-09',
                'MT-10',
                'Tracer 900',
                'XSR700',
                'XSR900',
                'Tenere 700',
                'XMAX 300',
                'NMAX 155',
                'Aerox 155'
            ],
            'Honda' => [
                'CBR1000RR',
                'CBR650R',
                'CB650R',
                'CB125R',
                'CRF1100L',
                'Gold Wing',
                'Rebel 500',
                'PCX 160',
                'SH150i',
                'Forza 350'
            ],
            'Kawasaki' => [
                'Ninja ZX-10R',
                'Ninja 650',
                'Z650',
                'Z900',
                'Versys 650',
                'Vulcan S',
                'KLX230',
                'Ninja 400'
            ],
            'Suzuki' => [
                'GSX-R1000',
                'GSX-R750',
                'GSX-S750',
                'V-Strom 650',
                'Hayabusa',
                'Boulevard M109R',
                'SV650'
            ],
            'BMW' => [
                'S1000RR',
                'R1250GS',
                'F850GS',
                'R18',
                'K1600GT',
                'G310GS',
                'CE 04',
                'C400X'
            ],
            'Ducati' => [
                'Panigale V4',
                'Monster 937',
                'Multistrada V4',
                'Scrambler Icon',
                'Diavel 1260',
                'SuperSport 950'
            ],
            'KTM' => [
                '1290 Super Duke R',
                '890 Duke',
                '390 Duke',
                '1290 Super Adventure',
                '690 Enduro R',
                '450 SX-F',
                'RC 390'
            ],
            'Harley-Davidson' => [
                'Street Glide',
                'Road King',
                'Sportster S',
                'Fat Boy',
                'Iron 883',
                'Forty-Eight',
                'Ultra Limited'
            ],
            'Triumph' => [
                'Street Triple',
                'Speed Triple',
                'Tiger 900',
                'Bonneville T120',
                'Rocket 3',
                'Daytona Moto2 765'
            ],

            // SCOOTER MODELS
            'Piaggio' => [
                'Liberty 150',
                'Beverly 300',
                'MP3 300',
                'Medley 150',
                'Vespa GTS 300',
                'Vespa Primavera 150',
                'Vespa Sprint 150'
            ],
            'Vespa' => [
                'GTS Super 300',
                'Primavera 150',
                'Sprint 150',
                'Elettrica',
                'LX 150',
                'GTV 300'
            ],
            'Kymco' => [
                'AK 550',
                'Xciting S 400',
                'People S 300',
                'Like 125',
                'Agility 125',
                'Super 8 150'
            ],
            'SYM' => [
                'Maxsym TL 500',
                'Citycom 300',
                'Fiddle III 125',
                'Orbit III 125',
                'Mio 115'
            ],

            // BICYCLE MODELS
            'Trek' => [
                'Domane SL 7',
                'Emonda ALR 5',
                'Fuel EX 9.8',
                'Rail 9.8',
                'FX 3 Disc',
                'Verve+ 2'
            ],
            'Giant' => [
                'TCR Advanced Pro',
                'Defy Advanced',
                'Trance X 29',
                'Reign 29',
                'Escape 3',
                'Quick-E+'
            ],
            'Specialized' => [
                'Tarmac SL7',
                'Roubaix Sport',
                'Stumpjumper EVO',
                'Turbo Levo',
                'Sirrus X 4.0',
                'Como 4.0'
            ],
            'Cannondale' => [
                'SuperSix EVO',
                'Synapse Carbon',
                'Scalpel-Si',
                'Moterra NEO',
                'Quick CX 4',
                'Adventure EQ'
            ],
            'Scott' => [
                'Addict RC',
                'Speedster 20',
                'Spark 970',
                'Strike eRIDE 930',
                'Sub Cross 50',
                'E-Silence EVO'
            ],

            // ELECTRIC MODELS
            'Zero Motorcycles' => [
                'SR/F',
                'SR/S',
                'DS',
                'FX',
                'S'
            ],
            'NIU' => [
                'NGT',
                'NQi Pro',
                'MQi+',
                'UQi+',
                'Gova G3'
            ],
            'Energica' => [
                'Eva Ribelle',
                'Ego+',
                'Eva EsseEsse9+'
            ]
        ];

        foreach ($brandsWithModels as $brandTitle => $models) {
            // Get all brands with this name (could be in multiple categories)
            $brands = Brand::where('name', $brandTitle)->get();

            foreach ($brands as $brand) {
                foreach ($models as $modelTitle) {
                    VehicleModel::updateOrCreate([
                        'brand_id' => $brand->id,
                        'name' => $modelTitle,
                    ]);
                }
            }
        }
    }
}
