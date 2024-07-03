<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('get_ip', function (Request $request) {
    dd($request->ip());
});

// ipconfig
// copiare -> Indirizzo IPv4
// php artisan serve --host=xxx.xxx.xxx.xxx (Indirizzo IPv4)


// OPPURE PIU SEMPLICE

// php artisan serve --host=0.0.0.0
