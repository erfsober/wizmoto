<?php

use App\Http\Controllers\Wizmoto\AdvertisementController;
use App\Http\Controllers\Wizmoto\BlogController;
use App\Http\Controllers\Wizmoto\ChatController;
use App\Http\Controllers\Wizmoto\DashboardController;
use App\Http\Controllers\Wizmoto\HomeController;
use App\Http\Controllers\Wizmoto\ReviewController;
use App\Http\Controllers\SupportChatController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Wizmoto\AboutController;
use App\Http\Controllers\Wizmoto\FaqController;

Route::get('/' , [ HomeController::class , 'index' , ])->name('home');
Route::get('/inventory-list' , [ HomeController::class , 'inventoryList' , ])->name('inventory.list');
Route::get('/load-more-equipment' , [ HomeController::class , 'loadMoreEquipment' , ])->name('equipment.load-more');
Route::get('/get-models-by-brand' , [ HomeController::class , 'getModelsByBrand' , ])->name('home.get-models-by-brand');
Route::get('/get-advertisement-count' , [ HomeController::class , 'getAdvertisementCount' , ])->name('home.get-advertisement-count');
Route::get('/live-search' , [ HomeController::class , 'liveSearch' , ])->name('home.live-search');

Route::get('/blogs' , [ BlogController::class , 'index' , ])->name('blogs.index');
Route::get('/blogs/{slug}' , [ BlogController::class , 'show' , ])->name('blogs.show');
Route::post('/reviews/store' , [ ReviewController::class , 'store' , ])->name('reviews.store');

Route::get('/about-us' , [ AboutController::class , 'index' , ])->name('about.index');
Route::get('/faq' , [ FaqController::class , 'index' , ])->name('faq.index');

// Support chat routes
Route::get('/support-chat', [SupportChatController::class, 'index'])->name('support.chat');
Route::get('/support-chat/init', [SupportChatController::class, 'initChat'])->name('support.chat.init');
Route::post('/support-chat/send', [SupportChatController::class, 'sendMessage'])->name('support.chat.send');

// Protected support chat routes (require authentication like guest-provider system)
Route::middleware(['auth:provider'])->group(function () {
    Route::post('/support-chat/provider-send', [SupportChatController::class, 'sendProviderMessage'])->name('support.chat.provider.send');
    Route::get('/support-chat/messages', [SupportChatController::class, 'getMessages'])->name('support.chat.messages');
});

// Settings API routes
Route::get('/api/settings/whatsapp-number', function() {
    $whatsappNumber = \App\Models\Setting::get('whatsapp_number');
    return response()->json([
        'success' => true,
        'value' => $whatsappNumber
    ]);
});
// Guest chat routes - UUID based
Route::prefix('chat')->group(function () {
    Route::post('/initiate', [ChatController::class, 'initiateChat'])->name('chat.initiate');
    Route::post('/guest/send', [ChatController::class, 'sendGuestMessage'])->name('chat.guest.send');
    Route::post('/guest/messages', [ChatController::class, 'getChatMessages'])->name('chat.guest.messages');
    Route::get('/guest/{accessToken}', [ChatController::class, 'showGuestChat'])->name('chat.guest.show');
    Route::post('/guest/share-email', [ChatController::class, 'shareGuestEmail'])->name('chat.guest.share-email');
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
        
        // Provider chat management - UUID based
        Route::get('/conversations', [ChatController::class, 'showProviderChats'])->name('dashboard.conversations');
        Route::get('/conversations/{conversationUuid}', [ChatController::class, 'getProviderConversation'])->name('dashboard.conversation.show');
        Route::post('/conversations/{conversationUuid}/request-contact', [ChatController::class, 'requestGuestContact'])->name('dashboard.conversation.request-contact');
        Route::post('/send-provider-message', [ChatController::class, 'sendProviderMessage'])->name('dashboard.send-provider-message');
     });

require( __DIR__ . '/vendor/provider.php' );
require( __DIR__ . '/vendor/vehicle_model.php' );


