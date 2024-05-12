<?php

use App\Http\Controllers\Admin\AdminConductorController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminDriverController;
use App\Http\Controllers\Admin\AdminScheduleController;
use App\Http\Controllers\Admin\AdminTerminalController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::middleware(['role:bus admin|super admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->middleware(['auth', 'verified']);

    Route::controller(ServiceController::class)->group(function () {
    	Route::get('services/', 'index')->name('admin.service.index');
    	Route::get('services/create', 'create')->name('admin.service.create');
    	Route::post('services', 'store')->name('admin.service.store');
    	Route::get('services/{service}/edit', 'edit')->name('admin.service.edit');
    	Route::put('services/{service}', 'update')->name('admin.service.update');
    	Route::delete('services/{service}', 'destroy')->name('admin.service.destroy');
    });

    Route::controller(AdminTerminalController::class)->group(function () {
        Route::get('/terminals', 'index')->name('admin.terminals.index');
        Route::get('/terminals/create', 'create')->name('admin.terminals.create');
        Route::post('/terminals', 'store')->name('admin.terminals.store');
        Route::get('/terminals/{terminal}/edit', 'edit')->name('admin.terminals.edit');
        Route::put('/terminals/{terminal}', 'update')->name('admin.terminals.update');
        Route::delete('/terminals/{terminal}', 'destroy')->name('admin.terminals.destroy');
    });

    Route::controller(AdminScheduleController::class)->group(function () {
        Route::get('/schedules/create', 'create')->name('admin.schedules.create');
        Route::post('/schedules', 'store')->name('admin.schedules.store');

        Route::get('/schedules/{schedule}/edit', 'edit')->name('admin.schedules.edit');
        Route::put('/schedules/{schedule}', 'update')->name('admin.schedules.update');

        Route::delete('/schedules/{schedule}', 'destroy')->name('admin.schedules.destroy');
    });

    Route::controller(BusController::class)->group(function () {
        Route::get('/buses', 'index')->name('admin.buses.index');
        Route::get('/buses/create', 'create')->name('admin.buses.create');
        Route::post('/buses', 'store')->name('admin.buses.store');
        Route::get('/buses/{bus}/', 'show')->name('admin.buses.show');
        Route::get('/buses/{bus}/edit', 'edit')->name('admin.buses.edit');
        Route::put('/buses/{bus}', 'update')->name('admin.buses.update');
        Route::delete('/buses/{bus}', 'destroy')->name('admin.buses.destroy');
    });

    Route::controller(AdminDriverController::class)->group(function () {
        Route::get('/drivers', 'index')->name('admin.drivers.index');
        Route::get('/drivers/create', 'create')->name('admin.drivers.create');
        Route::post('/drivers', 'store')->name('admin.drivers.store');

        Route::get('/drivers/{driver}/edit', 'edit')->name('admin.drivers.edit');
        Route::put('/drivers/{driver}', 'update')->name('admin.drivers.update');
        Route::delete('/drivers/{driver}', 'destroy')->name('admin.drivers.destroy');
    });

    Route::controller(AdminConductorController::class)->group(function () {
        Route::get('/conductors', 'index')->name('admin.conductors.index');
        Route::get('/conductors/create', 'create')->name('admin.conductors.create');

        Route::post('/conductors', 'store')->name('admin.conductors.store');
        Route::get('/conductors/{conductor}/edit', 'edit')->name('admin.conductors.edit');
        Route::put('/conductors/{conductor}', 'update')->name('admin.conductors.update');
        Route::delete('/conductors/{conductor}', 'destroy')->name('admin.conductors.destroy');
    });
});
