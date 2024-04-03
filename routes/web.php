<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\MainController;
use App\Http\Controllers\Admin\MainController as AdminMainController;
use App\Http\Controllers\Admin\ApartmentController as AdminApartmentController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [MainController::class, 'index'])->name('home');

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth')
    ->group(function () {

        Route::get('/dashboard', [AdminMainController::class, 'dashboard'])->name('dashboard');

        Route::resource('apartments', AdminApartmentController::class);
        
        Route::get('/restore',[ AdminApartmentController::class, 'restore'])->name('restore');

        // payment
        Route::get('/checkout', [AdminPaymentController::class, 'checkout'])->name('checkout');
        Route::post('/processPayment', [AdminPaymentController::class, 'processPayment'])->name('processPayment');
    });



require __DIR__ . '/auth.php';
