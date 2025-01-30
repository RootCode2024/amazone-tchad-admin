<?php

use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;
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
    $destinations = ['NDAMENA', 'COTONOU', 'DAKAR', 'LIBREVILLE'];
    $origins = ['NDAMENA', 'COTONOU', 'DAKAR', 'LIBREVILLE'];
    $pickupLocations = ['cotonou', 'dakar', 'mbour'];
    return view('welcome', compact('destinations', 'origins', 'pickupLocations'));
});

Route::post('/reservations/vol', [ReservationController::class, 'store'])->name('reservations.store.vol');
Route::post('/reservations/hotel', [ReservationController::class, 'store'])->name('reservations.store.hotel');
Route::post('/reservations/volhotel', [ReservationController::class, 'store'])->name('reservations.store.volhotel');
Route::post('/reservations/carlocation', [ReservationController::class, 'store'])->name('reservations.store.location');

Route::get('/admin/reservations', [ReservationController::class, 'index'])->name('reservations.index');
Route::post('/admin/reservations/{reservation}/validate', [ReservationController::class, 'validateReservation'])->name('reservations.validate');
Route::post('/admin/reservations/{reservation}/reject', [ReservationController::class, 'rejectReservation'])->name('reservations.reject');
Route::post('/admin/reservations/{reservation}/pending', [ReservationController::class, 'pending'])->name('reservations.pending');

Route::get('/admin/clients', [ClientController::class, 'index'])->name('clients.index');

require __DIR__.'/auth.php';
require __DIR__.'/backend.php';
