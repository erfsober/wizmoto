<?php

use App\Http\Controllers\Wizmoto\AdvertisementController;
use App\Http\Controllers\Wizmoto\DashboardController;
use App\Http\Controllers\Wizmoto\HomeController;
use App\Http\Controllers\Wizmoto\Provider\Auth\AuthController;
use App\Http\Controllers\Wizmoto\Provider\Auth\ProviderController;
use Illuminate\Support\Facades\Route;

Route::get('/' , [
    HomeController::class ,
    'index' ,
])->name('home');
Route::get('/inventory-list' , [
    HomeController::class ,
    'inventoryList' ,
])->name('inventory-list');
// advertisements group
Route::prefix('advertisements')
     ->group(function () {
         Route::get('/{id}' , [
             AdvertisementController::class ,
             'show' ,
         ])->name('advertisements.show');
     });
// dashboard
Route::prefix('dashboard')
     ->group(function () {
         Route::get('/create-advertisement' , [ DashboardController::class , 'createAdvertisement' , ])->name('dashboard.create-advertisement');
         Route::post('/store-advertisement' , [ DashboardController::class , 'storeAdvertisement' , ])->name('dashboard.store-advertisement');

     });

require( __DIR__ . '/vendor/provider.php' );
require( __DIR__ . '/vendor/vehicle_model.php' );


