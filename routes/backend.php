<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\BackendReservationController;

//ROUTES BACKEND

// Routes pour le dashboard Administrateur
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class,'index'])->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('admin.profile.destroy');
    });

    Route::get('/users', [DashboardController::class, 'users'])->middleware(['auth', 'verified'])->name('users');
});


Route::get('/admin/clients/{id}/details', [BackendReservationController::class, 'clientDetails'])->name('client.details');

// Routes pour les réservations

Route::prefix('/admin/reservations')->middleware('auth')->group(function () {
    
    Route::get('/', [BackendReservationController::class, 'index'])->name('reservations.index');
    Route::get('/{client_id}/{reservation_id}', [BackendReservationController::class, 'show'])->name('reservations.show');

    // Routes pour récupérer les réservations par type
    Route::get('/fetchVols', [BackendReservationController::class, 'fetchReservations'])->name('reservations.fetchVols');
    Route::get('/fetchHotels', [BackendReservationController::class, 'fetchReservations'])->name('reservations.fetchHotels');
    Route::get('/fetchLocations', [BackendReservationController::class, 'fetchReservations'])->name('reservations.fetchLocations');
    
    // Routes pour mis à jour du status des reservations
    Route::post('/{id}/update-status-hotel', [ReservationController::class, 'updateStatusHotel']);
    Route::post('/{id}/update-status-car-location', [ReservationController::class, 'updateStatusCarLocation']);
    Route::post('/{id}/update-status-flight', [ReservationController::class, 'updateStatusFlight']);
    
    //Routes pour supprimer des reservations
    Route::delete('/delete/flight/{id}', [BackendReservationController::class, 'destroyvol']);
    Route::delete('/delete/hotel/{id}', [BackendReservationController::class, 'destroyHotel']);
    Route::delete('/delete/carlocation/{id}', [BackendReservationController::class, 'destroyCar']);
});





Route::prefix('/admin')->middleware('auth')->group(function () {
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/client/{id}', [ClientController::class, 'show'])->name('client.show');
    Route::get('/clients/fetch', [ClientController::class, 'fetchClients'])->name('clients.fetch');
    Route::delete('/clients/delete/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');
});