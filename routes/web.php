<?php

use App\Http\Controllers\BusController;
use App\Http\Controllers\ConductorController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\TicketPaymentController\PassengerTicketController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TicketPaymentController\PassengerTicketPaymentController;
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

Route::controller(ScheduleController::class)->group(function () {
	Route::get('/schedules', 'index')->name('schedules.index');

	Route::get('/schedules/create', 'create')->name('schedules.create');
	Route::post('/schedules', 'store')->name('schedules.store');

	Route::put('/schedules/{schedule}/book/{ticket}', 'book')->name('schedules.book');

	Route::get('/schedules/{schedule}', 'show')->name('schedules.show');
	Route::get('/schedules/{schedule}/edit', 'edit')->name('schedules.edit');
	Route::put('/schedules/{schedule}', 'update')->name('schedules.update');

	Route::delete('/schedules/{schedule}', 'destroy')->name('schedules.destroy');
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


    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin', function () {
            return view('dashboard');
        })->middleware(['auth', 'verified']);


        Route::controller(BusController::class)->group(function () {
            Route::get('/buses', 'index')->name('buses.index');
            Route::get('/buses/create', 'create')->name('buses.create');
            Route::post('/buses', 'store')->name('buses.store');
            Route::get('/buses/{bus}/', 'show')->name('buses.show');
            Route::get('/buses/{bus}/edit', 'edit')->name('buses.edit');
            Route::put('/buses/{bus}', 'update')->name('buses.update');
            Route::delete('/buses/{bus}', 'destroy')->name('buses.destroy');
        });

        Route::controller(DriverController::class)->group(function () {
            Route::get('/drivers', 'index')->name('drivers.index');
            Route::get('/drivers/create', 'create')->name('drivers.create');

            Route::get('/drivers/{driver}', 'show')
                 ->name('drivers.show')
                ->withoutMiddleware('role:admin');

            Route::post('/drivers', 'store')->name('drivers.store');
            Route::get('/drivers/{driver}/edit', 'edit')->name('drivers.edit');
            Route::put('/drivers/{driver}', 'update')->name('drivers.update');
            Route::delete('/drivers/{driver}', 'destroy')->name('drivers.destroy');
        });

        Route::controller(ConductorController::class)->group(function () {
            Route::get('/conductors', 'index')->name('conductors.index');
            Route::get('/conductors/create', 'create')->name('conductors.create');

            Route::get('/conductors/{conductor}', 'show')
                 ->name('conductors.show')
                 ->withoutMiddleware('role:admin');

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

        Route::get('/tickets', [PassengerTicketController::class, 'index'])->name('passenger.tickets');

        Route::post('/payment', [PassengerTicketPaymentController::class, 'pay'])->name('payment.pay');
        Route::get('/payment/callback', [PassengerTicketPaymentController::class, 'callback'])->name('payment.callback');
        Route::get('/payment/failed', [PassengerTicketPaymentController::class, 'failed'])->name('payment.failed');

    });
});



require __DIR__.'/auth.php';
