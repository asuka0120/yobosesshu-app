<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChildController;
use App\Http\Controllers\VaccinationScheduleController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::resource('children', ChildController::class);
    Route::get('/children/{child}/schedules', [VaccinationScheduleController::class, 'index'])->name('schedules.index');
    Route::post('/children/{child}/schedules/{schedule}/complete', [VaccinationScheduleController::class, 'complete'])->name('schedules.complete');
});

require __DIR__.'/auth.php';