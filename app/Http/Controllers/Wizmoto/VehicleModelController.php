<?php

namespace App\Http\Controllers\Wizmoto;

use App\Http\Controllers\Controller;
use App\Models\AdvertisementType;
use App\Models\Brand;
use App\Models\Equipment;
use App\Models\FuelType;
use App\Models\VehicleBody;
use App\Models\VehicleColor;
use App\Models\VehicleModel;

class VehicleModelController extends Controller {
    public function getModels ( $brandId ) {
        $vehicleModels = VehicleModel::query()
                                     ->where('brand_id' , $brandId)
                                     ->pluck('name' , 'id');

        return response()->json($vehicleModels);
    }
    public function getData ( $advertisementTypeId) {
        // Get brands that belong to this advertisement type (many-to-many)
        $brands = Brand::whereHas('advertisementTypes', function($q) use ($advertisementTypeId) {
            $q->where('advertisement_types.id', $advertisementTypeId);
        })->get();
        
        $vehicleBodies = VehicleBody::where('advertisement_type_id' , $advertisementTypeId)
                                    ->get();

        $equipments = Equipment::query()
                               ->where('advertisement_type_id' , $advertisementTypeId)
                               ->get();
        
        // Fuel types are now universal - not tied to advertisement types
        $fuelTypes = FuelType::all();

        return response()->json([
                                    'brands' => $brands,
                                    'vehicleBodies' => $vehicleBodies,
                                    'equipments' => $equipments,
                                    'fuelTypes' => $fuelTypes,
                                ]);
    }
}
