<?php

use App\Http\Controllers\Wizmoto\VehicleModelController;
use Illuminate\Support\Facades\Route;

Route::prefix('vehicle-models')->name('vehicle-models.')->group(function () {
    Route::get('/{brandId}', [VehicleModelController::class, 'getModels'])->name("get-models-based-on-brand");
    Route::get('getData/{advertisementTypeId}', [VehicleModelController::class, 'getData'])->name("get-data");
});
