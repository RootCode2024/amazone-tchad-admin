<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\DashboardController;


Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class,'index'])->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('admin.profile.destroy');
    });
});