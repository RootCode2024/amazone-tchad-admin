<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ReservationController;


//ROUTES FRONTEND

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::post('/reservations/vol', [ReservationController::class, 'storeFlight'])->name('reservations.store.vol');
Route::post('/reservations/hotel', [ReservationController::class, 'storeHotel'])->name('reservations.store.hotel');
Route::post('/reservations/volhotel', [ReservationController::class, 'storeFlightHotel'])->name('reservations.store.volhotel');
Route::post('/reservations/carlocation', [ReservationController::class, 'storeCarLocation'])->name('reservations.store.location');

require __DIR__.'/auth.php';
require __DIR__.'/backend.php';
