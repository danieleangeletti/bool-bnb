<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApartmentController as ApiApartment;
use App\Http\Controllers\Api\ApartmentController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\ServiceController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::name('api.')->group(function(){

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });
    Route::resource('apartments', ApiApartment::class)->only([
            'index',
            'show'
        ]);
    Route::resource('services', ServiceController::class)->only(['index']);
    Route::get('/getApartments', [ApartmentController::class, 'getApartments'])->name('getApartments');
    Route::get('/advancedResearch', [ApartmentController::class, 'advancedResearch'])->name('advancedResearch');
    Route::post('/store/{slug}',[MessageController::class, 'store']);
});


    