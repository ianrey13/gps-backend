<?php

use App\Http\Controllers\Api\LocationController;
use Illuminate\Support\Facades\Route;

Route::post('/locations', [LocationController::class, 'store']);
Route::get('/locations', [LocationController::class, 'index']);
Route::get('/locations/latest', [LocationController::class, 'latest']);
Route::get('/devices', [LocationController::class, 'devices']);