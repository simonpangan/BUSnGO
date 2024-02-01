<?php

use App\Http\Controllers\BusController;
use App\Http\Controllers\ConductorController;
use App\Http\Controllers\DriverController;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    $authenticatedUser = Auth::user();

    if ($authenticatedUser->hasRole('admin')) {
        return redirect()->to(RouteServiceProvider::ADMIN);
    } elseif ($authenticatedUser->hasRole('driver')) {
        return redirect()->to(RouteServiceProvider::DRIVER);
    } elseif ($authenticatedUser->hasRole('conductors')) {
        return redirect()->to(RouteServiceProvider::CONDUCTOR);
    } elseif ($authenticatedUser->hasRole('passenger')) {
        return redirect()->to(RouteServiceProvider::PASSENGER);
    }
})->middleware(['auth', 'verified']);

Route::group(['middleware' => ['auth', 'verified']], function () {


    //ADMIN ROUTES
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin', function () {
            return view('dashboard');
        })->middleware(['auth', 'verified']);


        Route::controller(BusController::class)->group(function () {
            Route::get('/buses', 'index')->name('buses.index');
            Route::post('/buses', 'create')->name('buses.create');
            Route::get('/buses/{bus}/edit', 'edit')->name('buses.edit');
            Route::put('/buses/{bus}', 'update')->name('buses.update');
            Route::delete('/buses/{bus}', 'destroy')->name('buses.destroy');
        });

        Route::controller(DriverController::class)->group(function () {
            Route::get('/drivers', 'index')->name('drivers.index');
            Route::get('/drivers/create', 'create')->name('drivers.create');
            Route::get('/drivers/{driver}', 'show')->name('drivers.show');
            Route::post('/drivers', 'store')->name('drivers.store');
            Route::get('/drivers/{driver}/edit', 'edit')->name('drivers.edit');
            Route::put('/drivers/{driver}', 'update')->name('drivers.update');
            Route::delete('/drivers/{driver}', 'destroy')->name('drivers.destroy');
        });

        Route::controller(ConductorController::class)->group(function () {
            Route::get('/conductors', 'index')->name('conductors.index');
            Route::get('/conductors/create', 'create')->name('conductors.create');
            Route::post('/conductors', 'store')->name('conductors.store');
            Route::get('/conductors/{conductor}/edit', 'edit')->name('conductors.edit');
            Route::put('/conductors/{conductor}', 'update')->name('conductors.update');
            Route::delete('/conductors/{conductor}', 'destroy')->name('conductors.destroy');
        });
    });

    //DRIVER ROUTES
    Route::middleware(['role:driver'])->group(function () {
//        Route::get('/driver', function () {
//            return view('dashboard');
//        })->middleware(['auth', 'verified']);
    });

    //CONDUCTOR ROUTES
    Route::middleware(['role:conductors'])->group(function () {

    });


    //PASSENGERs ROUTES
    Route::middleware(['role:passenger'])->group(function () {

        Route::get('/passenger', function () {
            return view('dashboard');
        });

//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});



require __DIR__.'/auth.php';
