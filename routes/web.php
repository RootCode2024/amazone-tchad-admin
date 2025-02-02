<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\Backend\BackendReservationController;
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


// Route::get('/admin/reservations', [ClientController::class, 'reservations'])->name('clients.reservations');

Route::prefix('/admin/reservations')->group(function () {
    Route::get('/', [BackendReservationController::class, 'index'])->name('reservations.index');
    Route::get('/{id}', [BackendReservationController::class, 'show'])->name('reservations.show');

    // Routes pour récupérer les réservations par type
    Route::get('/fetchVols', [BackendReservationController::class, 'fetchReservations'])->name('reservations.fetchVols');
    Route::get('/fetchHotels', [BackendReservationController::class, 'fetchReservations'])->name('reservations.fetchHotels');
    Route::get('/fetchVolsHotels', [BackendReservationController::class, 'fetchReservations'])->name('reservations.fetchVolsHotels');
    Route::get('/fetchLocations', [BackendReservationController::class, 'fetchReservations'])->name('reservations.fetchLocations');

    Route::delete('/delete/{id}', [BackendReservationController::class, 'destroy'])->name('reservations.destroy');
});

Route::get('/admin/client/{id}', [ClientController::class, 'show'])->name('client.show');

Route::prefix('/admin/clients')->group(function () {
    Route::get('/', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/fetch', [ClientController::class, 'fetchClients'])->name('clients.fetch');
    Route::delete('/delete/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/backend.php';
