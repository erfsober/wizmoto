<?php

namespace App\Http\Controllers\Wizmoto;

use App\Http\Controllers\Controller;
use App\Models\VehicleModel;

class VehicleModelController extends Controller {
    public function getModels ( $brandId ) {
        $vehicleModels = VehicleModel::query()
                                     ->where('brand_id' , $brandId)
                                     ->pluck('name' , 'id');

        return response()->json($vehicleModels);
    }
}
