<?php

use App\Http\Controllers\Wizmoto\AdvertisementController;
use App\Http\Controllers\Wizmoto\DashboardController;
use App\Http\Controllers\Wizmoto\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/' , [
    HomeController::class ,
    'index' ,
]);
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
         Route::get('/create-advertisement' , [
             DashboardController::class ,
             'createAdvertisement' ,
         ])->name('dashboard.create-advertisement');
     });
