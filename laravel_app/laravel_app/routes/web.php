<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChildController;
use App\Http\Controllers\VaccinationScheduleController;
use App\Http\Controllers\TrashController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::resource('children', ChildController::class);
    Route::get('/children/{child}/schedules', [VaccinationScheduleController::class, 'index'])->name('schedules.index');
    Route::post('/children/{child}/schedules/{schedule}/complete', [VaccinationScheduleController::class, 'complete'])->name('schedules.complete');

    // ゴミ箱
    Route::get('/trash', [TrashController::class, 'index'])->name('trash.index');
    Route::post('/trash/{id}/restore', [TrashController::class, 'restore'])->name('trash.restore');
    Route::delete('/trash/{id}/force-delete', [TrashController::class, 'forceDelete'])->name('trash.forceDelete');
});

require __DIR__.'/auth.php';