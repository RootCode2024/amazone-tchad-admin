<?php

use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\WelcomeController;



Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::post('/reservations/vol', [ReservationController::class, 'storeFlight'])->name('reservations.store.vol');
Route::post('/reservations/hotel', [ReservationController::class, 'storeHotel'])->name('reservations.store.hotel');
Route::post('/reservations/volhotel', [ReservationController::class, 'storeFlightHotel'])->name('reservations.store.volhotel');
Route::post('/reservations/carlocation', [ReservationController::class, 'storeCarLocation'])->name('reservations.store.location');

Route::get('/admin/reservations', [ReservationController::class, 'index'])->name('reservations.index');
Route::post('/admin/reservations/{reservation}/validate', [ReservationController::class, 'validateReservation'])->name('reservations.validate');
Route::post('/admin/reservations/{reservation}/reject', [ReservationController::class, 'rejectReservation'])->name('reservations.reject');
Route::post('/admin/reservations/{reservation}/pending', [ReservationController::class, 'pending'])->name('reservations.pending');

Route::get('/admin/clients', [ClientController::class, 'index'])->name('clients.index');
Route::get('/admin/reservations', [ClientController::class, 'reservations'])->name('clients.reservations');

require __DIR__.'/auth.php';
require __DIR__.'/backend.php';
