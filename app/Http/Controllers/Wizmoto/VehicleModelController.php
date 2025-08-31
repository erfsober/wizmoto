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
        $brands = Brand::where('advertisement_type_id' , $advertisementTypeId)
                       ->get();
        $vehicleBodies = VehicleBody::where('advertisement_type_id' , $advertisementTypeId)
                                    ->get();

        $equipments = Equipment::query()
                               ->where('advertisement_type_id' , $advertisementTypeId)
                               ->get();
        $fuelTypes = FuelType::query()
                             ->where('advertisement_type_id' , $advertisementTypeId)
                             ->get();

        return response()->json([
                                    'brands' => $brands,
                                    'vehicleBodies' => $vehicleBodies,
                                    'equipments' => $equipments,
                                    'fuelTypes' => $fuelTypes,
                                ]);
    }
}
