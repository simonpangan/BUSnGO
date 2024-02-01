<?php

use App\Http\Controllers\BusController;
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
Route::resource('drivers', DriverController::class);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $authenticatedUser = Auth::user();

    if ($authenticatedUser->hasRole('admin')) {
        return redirect()->to(RouteServiceProvider::ADMIN);
    } elseif ($authenticatedUser->hasRole('driver')) {
        return redirect()->to(RouteServiceProvider::DRIVER);
    } elseif ($authenticatedUser->hasRole('conductor')) {
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
    });

    //DRIVER ROUTES
    Route::middleware(['role:driver'])->group(function () {
//        Route::get('/driver', function () {
//            return view('dashboard');
//        })->middleware(['auth', 'verified']);
    });

    //CONDUCTOR ROUTES
    Route::middleware(['role:conductor'])->group(function () {

        Route::get('/conductor', function () {
            return view('dashboard');
        })->middleware(['auth', 'verified']);

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
