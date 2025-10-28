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
        })->get()->map(function($brand) {
            return [
                'id' => $brand->id,
                'name' => $brand->localized_name
            ];
        });
        
        $vehicleBodies = VehicleBody::where('advertisement_type_id' , $advertisementTypeId)
                                    ->get()->map(function($body) {
            return [
                'id' => $body->id,
                'name' => $body->localized_name
            ];
        });

        $equipments = Equipment::query()
                               ->where('advertisement_type_id' , $advertisementTypeId)
                               ->get()->map(function($equipment) {
            return [
                'id' => $equipment->id,
                'name' => $equipment->localized_name
            ];
        });
        
        // Fuel types are now universal - not tied to advertisement types
        $fuelTypes = FuelType::all()->map(function($fuel) {
            return [
                'id' => $fuel->id,
                'name' => $fuel->localized_name
            ];
        });

        return response()->json([
                                    'brands' => $brands,
                                    'vehicleBodies' => $vehicleBodies,
                                    'equipments' => $equipments,
                                    'fuelTypes' => $fuelTypes,
                                ]);
    }
}
