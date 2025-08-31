<?php

use App\Http\Controllers\Wizmoto\AdvertisementController;
use App\Http\Controllers\Wizmoto\BlogController;
use App\Http\Controllers\Wizmoto\DashboardController;
use App\Http\Controllers\Wizmoto\HomeController;
use App\Http\Controllers\Wizmoto\Provider\Auth\AuthController;
use App\Http\Controllers\Wizmoto\Provider\Auth\ProviderController;
use App\Http\Controllers\Wizmoto\ReviewController;
use App\Http\Controllers\Wizmoto\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/' , [ HomeController::class , 'index' , ])->name('home');
Route::get('/inventory-list' , [ HomeController::class , 'inventoryList' , ])->name('inventory.list');

Route::get('/blogs' , [ BlogController::class , 'index' , ])->name('blogs.index');
Route::get('/blogs/{slug}' , [ BlogController::class , 'show' , ])->name('blogs.show');
Route::post('/reviews/store' , [ ReviewController::class , 'store' , ])->name('reviews.store');
// advertisements group
Route::prefix('advertisements')->group(function () {
         Route::get('/{id}' , [ AdvertisementController::class , 'show' , ])->name('advertisements.show');
     });


// dashboard
Route::middleware(["auth"])->prefix('dashboard')
     ->group(function () {
         Route::get('/create-advertisement' , [ DashboardController::class , 'createAdvertisement' , ])->name('dashboard.create-advertisement');
         Route::post('/store-advertisement' , [ DashboardController::class , 'storeAdvertisement' , ])->name('dashboard.store-advertisement');
         Route::post('/delete-advertisement' , [ DashboardController::class , 'deleteAdvertisement' , ])->name('dashboard.delete-advertisement');
         Route::get('/my-advertisements' , [ DashboardController::class , 'myAdvertisements' , ])->name('dashboard.my-advertisements');
         Route::get('/profile' , [ DashboardController::class , 'profile' , ])->name('dashboard.profile');
         Route::post('/update-profile' , [ DashboardController::class , 'updateProfile' , ])->name('dashboard.update-profile');

     });

require( __DIR__ . '/vendor/provider.php' );
require( __DIR__ . '/vendor/vehicle_model.php' );


