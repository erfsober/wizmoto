<?php

namespace App\Http\Controllers\Wizmoto;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\AdvertisementType;
use App\Models\Brand;
use App\Models\Equipment;
use App\Models\FuelType;
use App\Models\VehicleBody;
use App\Models\VehicleColor;
use App\Models\VehicleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller {
    public function index () {
        $newAdvertisements = Advertisement::query()
                                          ->latest()
                                          ->limit(12)
                                          ->get();
        $usedAdvertisements = Advertisement::query()
                                           ->where('vehicle_category' , 'Used')
                                           ->latest()
                                           ->limit(12)
                                           ->get();
        $brands = Brand::all();
        $vehicleModels = VehicleModel::all();
        $advertisementTypes = AdvertisementType::all();
        $fuelTypes = FuelType::all();
        $vehicleBodies = VehicleBody::all();
        $vehicleColors = VehicleColor::query()
                                     ->get();
        $equipments = Equipment::query()
                               ->get();

        return view('wizmoto.home.index' , compact('newAdvertisements' , 'usedAdvertisements' , 'brands' , 'vehicleModels' , 'advertisementTypes' , 'fuelTypes' , 'vehicleBodies' , 'vehicleColors' , 'equipments'));
    }

    public function inventoryList ( Request $request ) {
        $brands = Brand::all();
        $vehicleModels = VehicleModel::all();
        $advertisementTypes = AdvertisementType::all();
        $fuelTypes = FuelType::all();
        $vehicleBodies = VehicleBody::all();
        $vehicleColors = VehicleColor::query()
                                     ->get();
        $equipments = Equipment::query()
                               ->get();
        $advertisements = Advertisement::query()
                                       ->with([
                                                  'brand' ,
                                                  'vehicleModel' ,
                                                  'vehicleBody' ,
                                                  'vehicleColor' ,
                                                  'fuelType' ,
                                              ])
                                       ->when($request->filled('city') , fn ( $q ) => $q->where('city' , $request->city))
                                       ->when($request->filled('zip_code') , fn ( $q ) => $q->where('zip_code' , $request->zip_code))
            // CONDITION / CATEGORY (e.g., Used, New, Classic/Era)
                                       ->when($request->filled('vehicle_category') , fn ( $q ) => $q->whereIn('vehicle_category' , (array)$request->vehicle_category))
            // TYPE / BODY
                                       ->when($request->filled('vehicle_body_id') , fn ( $q ) => $q->whereIn('vehicle_body_id' , (array)$request->vehicle_body_id))
            // MAKE / MODEL
                                       ->when($request->filled('brand_id') , fn ( $q ) => $q->where('brand_id' , $request->brand_id))
                                       ->when($request->filled('vehicle_model_id') , fn ( $q ) => $q->where('vehicle_model_id' , $request->vehicle_model_id))
            // YEAR
                                       ->when($request->filled('min_year') , fn ( $q ) => $q->where(DB::raw('CAST(registration_year AS UNSIGNED)') , '>=' , (int)$request->min_year))
                                       ->when($request->filled('max_year') , fn ( $q ) => $q->where(DB::raw('CAST(registration_year AS UNSIGNED)') , '<=' , (int)$request->max_year))
            // MILEAGE
                                       ->when($request->filled('mileage_max') , fn ( $q ) => $q->where('mileage' , '<=' , (int)$request->mileage_max))
                                       ->when($request->filled('mileage_min') , fn ( $q ) => $q->where('mileage' , '>=' , (int)$request->mileage_min))
            // TRANSMISSION
                                       ->when($request->filled('motor_change') , fn ( $q ) => $q->whereIn('motor_change' , (array)$request->motor_change))
            // FUEL
                                       ->when($request->filled('fuel_type_id') , fn ( $q ) => $q->whereIn('fuel_type_id' , (array)$request->fuel_type_id))
            // COLOR
                                       ->when($request->filled('color_id') , fn ( $q ) => $q->whereIn('color_id' , (array)$request->color_id))
            // EQUIPMENT (features)
                                       ->when($request->filled('equipment') , function ( $q ) use ( $request ) {
                $q->whereHas('equipments' , function ( $qq ) use ( $request ) {
                    $qq->whereIn('equipment_id' , (array)$request->equipment);
                });
            })
            // PRICE (final_price is string; cast to decimal)
                                       ->when($request->filled('min_price') , fn ( $q ) => $q->where(DB::raw('CAST(final_price AS DECIMAL(12,2))') , '>=' , (float)$request->min_price))
                                       ->when($request->filled('max_price') , fn ( $q ) => $q->where(DB::raw('CAST(final_price AS DECIMAL(12,2))') , '<=' , (float)$request->max_price))
                                       ->latest('id')
                                       ->paginate(10);

        return view('wizmoto.home.inventory-list' , compact('advertisements' , 'brands' , 'vehicleModels' , 'advertisementTypes' , 'fuelTypes' , 'vehicleBodies' , 'vehicleColors' , 'equipments'));
    }
}
