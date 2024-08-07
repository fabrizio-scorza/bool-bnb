<?php

use App\Http\Controllers\Admin\HouseController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\VueController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

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

Route::get('/', [VueController::class, 'homepage'])->name('homepage');
Route::get('/advanced-search', [VueController::class, 'advancedSearch'])->name('advanced');
Route::get('/public/{house}', [VueController::class, 'publicHouseShow'])->name('public');
Route::post('/public/store', [MessageController::class, 'store'])->name('store');
Route::get('/braintree/token', [PaymentController::class, 'token']);
Route::post('/braintree/checkout', [PaymentController::class, 'checkout']);

Route::middleware(['auth', 'verified'])
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {
        Route::resource('houses', HouseController::class);
        Route::get('plans', [PageController::class, 'plans'])->name('plans');
        Route::get('messages', [PageController::class, 'messages'])->name('messages');

        Route::post('/houses/{house}/restore', [HouseController::class, 'restore'])->name('houses.restore');
        // Route::delete('/houses/{house}/forceDestroy', [HouseController::class, 'forceDestroy'])->name('houses.forceDestroy');
    });



require __DIR__ . '/auth.php';