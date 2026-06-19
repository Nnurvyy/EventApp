<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->middleware('role:admin')
        ->name('admin.dashboard');

    // Admin Event CRUD
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('events', \App\Http\Controllers\Admin\EventController::class);
        Route::get('/registrations', [\App\Http\Controllers\EventRegistrationController::class, 'adminIndex'])->name('registrations.index');
        Route::delete('/registrations/{id}', [\App\Http\Controllers\EventRegistrationController::class, 'destroy'])->name('registrations.destroy');
    });

    // User Event Catalog
    Route::middleware('role:user')->group(function () {
        Route::get('/events', [\App\Http\Controllers\EventController::class, 'index'])->name('events.index');
        Route::get('/events/{event}', [\App\Http\Controllers\EventController::class, 'show'])->name('events.show');
        Route::post('/events/{event}/register', [\App\Http\Controllers\EventRegistrationController::class, 'store'])->name('events.register');
        Route::get('/registered-events', [\App\Http\Controllers\EventRegistrationController::class, 'index'])->name('events.registered');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
