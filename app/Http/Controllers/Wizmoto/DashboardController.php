<?php

namespace App\Http\Controllers\Wizmoto;

use App\Http\Controllers\Controller;
use App\Models\AdvertisementType;
use App\Models\Brand;
use App\Models\Equipment;
use App\Models\FuelType;
use App\Models\VehicleBody;
use App\Models\VehicleColor;
use Illuminate\Http\Request;

class DashboardController extends Controller {
    public function createAdvertisement () {
        $category = AdvertisementType::query()
                            ->where('title' , 'scooter')
                            ->first();
        $brands = Brand::where('advertisement_type_id' , $category->id)
                       ->get();
        $vehicleBodies = VehicleBody::where('advertisement_type_id' , $category->id)
                                    ->get();
        $vehicleColors = VehicleColor::query()
                                     ->get();
        $equipments = Equipment::query()
                               ->where('advertisement_type_id' , $category->id)
                               ->get();
        $fuelTypes = FuelType::query()
                             ->where('advertisement_type_id' , $category->id)
                             ->get();
        $internationalPrefixes = [
            '+1' ,
            '+30' ,
            '+31' ,
            '+32' ,
            '+33' ,
            '+34' ,
            '+351' ,
            '+352' ,
            '+353' ,
            '+354' ,
            '+355' ,
            '+356' ,
            '+358' ,
            '+359' ,
            '+36' ,
            '+370' ,
            '+371' ,
            '+372' ,
            '+373' ,
            '+375' ,
            '+376' ,
            '+377' ,
            '+378' ,
            '+379' ,
            '+380' ,
            '+381' ,
            '+382' ,
            '+385' ,
            '+386' ,
            '+387' ,
            '+389' ,
            '+39' ,
            '+40' ,
            '+41' ,
            '+420' ,
            '+421' ,
            '+423' ,
            '+43' ,
            '+44' ,
            '+45' ,
            '+46' ,
            '+47' ,
            '+48' ,
            '+49' ,
            '+52' ,
            '+55' ,
            '+7' ,
            '+90' ,
        ];

        return view('wizmoto.dashboard.create-advertisement' , compact('brands' , 'vehicleBodies' , 'vehicleColors' , 'equipments' , 'fuelTypes','internationalPrefixes'));
    }

    public function storeAdvertisement ( Request $request ) {
        dd($request->all());
    }
}
