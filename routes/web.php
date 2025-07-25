<?php

use App\Http\Controllers\Wizmoto\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/' , [
    HomeController::class ,
    'index',
]);
