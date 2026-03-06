<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChildController;
use App\Http\Controllers\VaccinationScheduleController;
use App\Http\Controllers\TrashController;
use App\Http\Controllers\SideEffectController;
use App\Http\Controllers\MedicalInstitutionController;
use App\Http\Controllers\AppointmentController;

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

    // 副反応
    Route::get('/children/{child}/side-effects', [SideEffectController::class, 'index'])->name('side_effects.index');
    Route::get('/children/{child}/side-effects/create', [SideEffectController::class, 'create'])->name('side_effects.create');
    Route::post('/children/{child}/side-effects', [SideEffectController::class, 'store'])->name('side_effects.store');
    Route::delete('/children/{child}/side-effects/{sideEffect}', [SideEffectController::class, 'destroy'])->name('side_effects.destroy');

    // 医療機関
    Route::resource('medical_institutions', MedicalInstitutionController::class);

    // 予約
    Route::get('/children/{child}/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/children/{child}/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/children/{child}/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::delete('/children/{child}/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
});

require __DIR__.'/auth.php';