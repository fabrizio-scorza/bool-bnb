<?php

use App\Http\Controllers\Admin\HouseController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {
        Route::resource('houses', HouseController::class);
        Route::get('plans', [PageController::class, 'plans'])->name('plans');
        Route::get('messages', [PageController::class, 'messages'])->name('messages');

        Route::post('/houses/{house}/restore', [HouseController::class, 'restore'])->name('houses.restore');
    });



require __DIR__ . '/auth.php';
