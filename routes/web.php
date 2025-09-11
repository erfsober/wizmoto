<?php

use App\Http\Controllers\Wizmoto\AdvertisementController;
use App\Http\Controllers\Wizmoto\BlogController;
use App\Http\Controllers\Wizmoto\ChatController;
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

// Guest chat routes
Route::prefix('chat')->group(function () {
    Route::post('/initiate', [ChatController::class, 'initiateChat'])->name('chat.initiate');
    Route::post('/guest/send', [ChatController::class, 'sendGuestMessage'])->name('chat.guest.send');
    Route::get('/guest/messages', [ChatController::class, 'getChatMessages'])->name('chat.guest.messages');
    Route::get('/guest/{providerId}', [ChatController::class, 'showGuestChat'])->name('chat.guest.show');
    Route::post('/guest/share-email', [ChatController::class, 'shareGuestEmail'])->name('chat.guest.share-email');
    Route::get('/conversation/{providerId}/{guestId}', [ChatController::class, 'continueConversation'])->name('chat.guest.continue');
});
// advertisements group
Route::prefix('advertisements')->group(function () {
         Route::get('/{id}' , [ AdvertisementController::class , 'show' , ])->name('advertisements.show');
     });


// dashboard
Route::middleware(["auth:provider"])->prefix('dashboard')
     ->group(function () {
         Route::get('/create-advertisement' , [ DashboardController::class , 'createAdvertisement' , ])->name('dashboard.create-advertisement');
         Route::post('/store-advertisement' , [ DashboardController::class , 'storeAdvertisement' , ])->name('dashboard.store-advertisement');
         Route::post('/delete-advertisement' , [ DashboardController::class , 'deleteAdvertisement' , ])->name('dashboard.delete-advertisement');
         Route::get('/edit-advertisement/{id}' , [ DashboardController::class , 'editAdvertisement' , ])->name('dashboard.edit-advertisement');
         Route::put('/update-advertisement' , [ DashboardController::class , 'updateAdvertisement' , ])->name('dashboard.update-advertisement');
         Route::get('/my-advertisements' , [ DashboardController::class , 'myAdvertisements' , ])->name('dashboard.my-advertisements');
         Route::get('/profile' , [ DashboardController::class , 'profile' , ])->name('dashboard.profile');
         Route::post('/update-profile' , [ DashboardController::class , 'updateProfile' , ])->name('dashboard.update-profile');
     
        Route::get('/chat', [DashboardController::class, 'messagesIndex'])->name('dashboard.messages');
        Route::get('/messages', [DashboardController::class, 'fetchMessages'])->name('dashboard.fetch-messages');
        Route::post('/messages', [DashboardController::class, 'sendMessage'])->name('dashboard.send-message');
        
        // Provider chat management
        Route::get('/conversations', [ChatController::class, 'showProviderChats'])->name('dashboard.conversations');
        Route::get('/conversations/{guestId}', [ChatController::class, 'getProviderConversation'])->name('dashboard.conversation.show');
        Route::post('/conversations/{guestId}/request-contact', [ChatController::class, 'requestGuestContact'])->name('dashboard.conversation.request-contact');
     });

require( __DIR__ . '/vendor/provider.php' );
require( __DIR__ . '/vendor/vehicle_model.php' );


