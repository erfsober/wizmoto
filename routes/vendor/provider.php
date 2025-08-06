<?php

use App\Http\Controllers\Wizmoto\Provider\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::prefix('provider')->group(function(){
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('provider.login');
    Route::post('login', [LoginController::class, 'login'])->name('provider.login.submit');
    Route::post('logout', [LoginController::class, 'logout'])->name('provider.logout');

    Route::middleware('auth:provider')->group(function(){
        Route::get('/dashboard', function(){
            return "Provider Dashboard";
        })->name('provider.dashboard');
    });
});
