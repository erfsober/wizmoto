<?php

namespace App\Http\Controllers\Wizmoto;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdvertisementRequest;
use App\Models\Advertisement;
use App\Models\AdvertisementType;
use App\Models\Brand;
use App\Models\Equipment;
use App\Models\FuelType;
use App\Models\VehicleBody;
use App\Models\VehicleColor;

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

        return view('wizmoto.dashboard.create-advertisement' , compact('brands' , 'vehicleBodies' , 'vehicleColors' , 'equipments' , 'fuelTypes' , 'internationalPrefixes'));
    }

    public function storeAdvertisement ( StoreAdvertisementRequest $request ) {
        $data = $request->validated();
        $data[ 'is_metallic_paint' ] = $request->has('is_metallic_paint');
        $data[ 'show_phone' ] = $request->has('show_phone');
        $data[ 'damaged_vehicle' ] = $request->has('damaged_vehicle');
        $data[ 'price_negotiable' ] = $request->has('price_negotiable');
        $data[ 'tax_deductible' ] = $request->has('tax_deductible');
        $data[ 'coupon_documentation' ] = $request->has('coupon_documentation');
        $advertisement = Advertisement::create($data);
        if ( $request->hasFile('images') ) {
            foreach ( $request->file('images') as $file ) {
                $advertisement->addMedia($file)
                              ->toMediaCollection('covers');
            }
        }

        if ($request->has('equipments')) {
            $advertisement->equipments()->sync($request->equipments);
        }

        return response()->json([
                                    'status' => 'success' ,
                                    'message' => 'Advertisement created successfully.' ,
                                    'data' => $advertisement ,
                                ] , 201);
    }
}
