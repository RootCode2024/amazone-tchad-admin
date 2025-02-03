<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\Backend\BackendReservationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\WelcomeController;


//ROUTES FRONTEND

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::post('/reservations/vol', [ReservationController::class, 'storeFlight'])->name('reservations.store.vol');
Route::post('/reservations/hotel', [ReservationController::class, 'storeHotel'])->name('reservations.store.hotel');
Route::post('/reservations/volhotel', [ReservationController::class, 'storeFlightHotel'])->name('reservations.store.volhotel');
Route::post('/reservations/carlocation', [ReservationController::class, 'storeCarLocation'])->name('reservations.store.location');



Route::post('/reservations/{id}/update-status-flight', [ReservationController::class, 'updateStatusFlight']);
Route::post('/reservations/{id}/update-status-hotel', [ReservationController::class, 'updateStatusHotel']);
Route::post('/reservations/{id}/update-status-car-location', [ReservationController::class, 'updateStatusCarLocation']);

require __DIR__.'/auth.php';
require __DIR__.'/backend.php';
