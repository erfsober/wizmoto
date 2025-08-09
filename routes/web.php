<?php

use App\Http\Controllers\Wizmoto\AdvertisementController;
use App\Http\Controllers\Wizmoto\DashboardController;
use App\Http\Controllers\Wizmoto\HomeController;
use App\Http\Controllers\Wizmoto\Provider\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/' , [
    HomeController::class ,
    'index' ,
])->name('home');
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
////provider login
Route::prefix('provider')->name('provider.')->group(function () {

    Route::get('/auth', [AuthController::class, 'showAuthForm'])->name('auth');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    // Authenticated
    Route::middleware('auth:provider')->group(function () {
        Route::get('dashboard', function () {
            return view('provider.dashboard');
        })->name('dashboard');

        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    });
});
