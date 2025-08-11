<?php

namespace Database\Seeders;

use App\Models\category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder {
    public function run (): void {
        $categories = [
            'Scooter' ,
            'Motorbike' ,
            'Bicycle' ,
            'E.Bike' ,
            'Monopattino',
        ];
        foreach ( $categories as $title ) {
            Category::updateOrCreate([ 'name' => $title ]);
        }
    }
}
