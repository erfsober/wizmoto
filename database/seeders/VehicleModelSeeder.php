<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\VehicleModel;
use Illuminate\Database\Seeder;

class VehicleModelSeeder extends Seeder {
    public function run (): void {
        $brandsWithModels = [
            'Piaggio' => [
                'Liberty 125' ,
                'Beverly 300',
            ] ,
            'Yamaha' => [
                'XMAX 125' ,
                'NMAX',
            ] ,
            'Vespa' => [
                'GTS Super' ,
                'Primavera',
            ] ,
            'Honda' => [
                'PCX 125' ,
                'SH 150',
            ] ,
        ];
        foreach ( $brandsWithModels as $brandTitle => $models ) {
            $brand = Brand::where('name' , $brandTitle)
                          ->first();
            if ( !$brand ) {
                continue;
            }
            foreach ( $models as $modelTitle ) {
                VehicleModel::updateOrCreate([
                                                 'brand_id' => $brand->id ,
                                                 'name' => $modelTitle ,
                                             ]);
            }
        }
    }
}
