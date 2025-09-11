<?php

use App\Http\Controllers\Wizmoto\Provider\Auth\AuthController;
use App\Http\Controllers\Wizmoto\Provider\Auth\ProviderController;
use Illuminate\Support\Facades\Route;


#provider login
Route::prefix('provider')->name('provider.')->group(function () {
    Route::get('/auth', [AuthController::class, 'showAuthForm'])->name('auth');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
      // OAuth Routes - ADD THESE
      Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
      Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
      Route::get('/auth/apple', [AuthController::class, 'redirectToApple'])->name('auth.apple');
      Route::get('/auth/apple/callback', [AuthController::class, 'handleAppleCallback'])->name('auth.apple.callback');
      
    // Forgot password
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    // Reset password
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.store');
    Route::get('/{id}' , [ ProviderController::class , 'show' ])->name('show');
    // Authenticated
    Route::middleware('auth:provider')->group(function () {
        Route::get('dashboard', function () {
            return view('provider.dashboard');
        })->name('dashboard');
    });
});


Route::get('providers/email/verify/{id}/{hash}', [ProviderController::class, 'emailVerify'])
     ->middleware(['signed'])
     ->name('verification.verify');
