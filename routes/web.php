<?php

use App\Http\Controllers\BusLocationController;
use App\Http\Controllers\ConductorController;
use App\Http\Controllers\MyScheduleController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\PassengerTicketController;
use App\Http\Controllers\PassengerTicketPaymentController;
use App\Http\Controllers\ScheduleController;
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

Route::view('/about', 'about')->name('about');

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

Route::controller(ScheduleController::class)->group(function () {
    Route::get('/schedules', 'index')->name('schedules.index');
    Route::get('/schedules/{schedule}', 'show')->name('schedules.show');
    Route::put('/schedules/{schedule}/book/{ticket}', 'book')->name('schedules.book');
});

Route::group(['middleware' => ['auth', 'verified']], function () {

    require __DIR__.'/admin.php';


    //DRIVER ROUTES
    Route::middleware(['role:driver'])->group(function () {
        Route::get('/driver', function () {
            return view('dashboard');
        })->middleware(['auth', 'verified']);

        Route::controller(DriverController::class)->group(function () {
             Route::get('/drivers/{driver}', 'show')
                 ->name('drivers.show')
                 ->withoutMiddleware('role:driver');
        });
    });

    //CONDUCTOR ROUTES
    Route::middleware(['role:conductor'])->group(function () {
        Route::get('/conductor', function () {
            return view('dashboard');
        });

        Route::get('/conductors/{conductor}', [ConductorController::class, 'show'])
             ->name('conductors.show')
             ->withoutMiddleware('role:conductor');

        Route::get('/bus-location', [BusLocationController::class, 'update'])->name('bus-location.update');
    });

    //PASSENGER ROUTES
    Route::middleware(['role:passenger'])->group(function () {
        Route::get('/passenger', function () {
            return view('dashboard');
        });

        Route::get('/tickets', [PassengerTicketController::class, 'index'])->name('passenger.tickets');

        Route::post('/payment/book', [PassengerTicketPaymentController::class, 'book'])->name('payment.book');
        Route::get('/payment/callback', [PassengerTicketPaymentController::class, 'callback'])->name('payment.callback');
        Route::get('/payment/failed', [PassengerTicketPaymentController::class, 'failed'])->name('payment.failed');
    });

    Route::middleware(['role:driver|conductor'])->group(function () {
        Route::get('/my-schedules', MyScheduleController::class)->name('my-schedule');
    });
});

//TODO: dapat yung driver ilalagay sa schedule

require __DIR__.'/auth.php';
