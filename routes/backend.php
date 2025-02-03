<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\BackendReservationController;

//ROUTES BACKEND

// Routes pour le dashboard
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class,'index'])->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('admin.profile.destroy');
    });
});



// Routes pour les réservations

Route::prefix('/admin/reservations')->group(function () {
    Route::get('/', [BackendReservationController::class, 'index'])->name('reservations.index');
    Route::get('/{client_id}/{reservation_id}', [BackendReservationController::class, 'show'])->name('reservations.show');

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