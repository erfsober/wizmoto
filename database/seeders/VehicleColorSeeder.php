<?php

namespace Database\Seeders;

use App\Models\VehicleColor;
use Illuminate\Database\Seeder;

class VehicleColorSeeder extends Seeder {
    public function run (): void {
        $colors = [
            [
                'name' => 'Red' ,
                'hex_code' => '#FF0000',
            ] ,
            [
                'name' => 'Blue' ,
                'hex_code' => '#0000FF',
            ] ,
            [
                'name' => 'Silver' ,
                'hex_code' => '#C0C0C0',
            ] ,
            [
                'name' => 'Black' ,
                'hex_code' => '#000000',
            ] ,
            [
                'name' => 'White' ,
                'hex_code' => '#FFFFFF',
            ] ,
            [
                'name' => 'Metallic Grey' ,
                'hex_code' => '#808080',
            ] ,
        ];
        foreach ( $colors as $color ) {
            VehicleColor::query()
                        ->create([
                                     'name' => $color[ 'name' ] ,
                                     'hex_code' => $color[ 'hex_code' ] ,
                                 ]);
        }
    }
}
