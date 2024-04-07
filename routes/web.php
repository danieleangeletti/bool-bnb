<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\MainController;
use App\Http\Controllers\Admin\MainController as AdminMainController;
use App\Http\Controllers\Admin\ApartmentController as AdminApartmentController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\MessageController as AdminMessageController;

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

        // Route::put('/restore',[ AdminApartmentController::class, 'restore'])->name('restore');
        Route::post('/apartments/{slug}/restore', [AdminApartmentController::class, 'restore'])->name('restore');
        // payment
        Route::get('/checkout', [AdminPaymentController::class, 'checkout'])->name('checkout');
        Route::post('/processPayment', [AdminPaymentController::class, 'processPayment'])->name('processPayment');
        Route::post('/messages', [AdminMessageController::class, 'store'])->name('messages.store'); // Route per salvare un nuovo messaggio
        Route::put('/messages/{message}/is_read', [AdminMessageController::class, 'isRead'])->name('messages.is_read');
    });



require __DIR__ . '/auth.php';
