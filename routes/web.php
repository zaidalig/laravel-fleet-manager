<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\FuelLogController;
use App\Http\Controllers\FuelReportController;
use App\Http\Controllers\MaintenanceRecordController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

Route::middleware(['auth', 'active.user'])->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('can:manage-fleet')->group(function () {
        Route::resource('vehicles', VehicleController::class);
        Route::resource('drivers', DriverController::class);
        Route::resource('fuel-logs', FuelLogController::class)->except(['show']);
        Route::resource('maintenance', MaintenanceRecordController::class)->except(['show']);
        Route::get('reports/fuel', [FuelReportController::class, 'index'])->name('reports.fuel');
    });

    Route::middleware('can:log-trips')->group(function () {
        Route::resource('trips', TripController::class)->only(['index', 'create', 'store', 'show']);
        Route::patch('trips/{trip}/status', [TripController::class, 'updateStatus'])->name('trips.status');
    });

    Route::middleware('can:manage-users')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
    });

    Route::get('activity-logs', [ActivityLogController::class, 'index'])->middleware('can:manage-users')->name('activity.index');
});
