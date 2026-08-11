<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\MonitorController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookReservationController;
/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/', [LoginController::class, 'showLoginForm']);

    Route::get('/login', [LoginController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login'])
        ->name('login.authenticate');
});


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/index', function () {
        return view('index');
    })->name('index');

    Route::get('/dashboard', function () {
        return view('index');
    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Attendance
    |--------------------------------------------------------------------------
    */

    Route::get('/attendance/status', [AttendanceController::class, 'status'])
        ->name('attendance.status');

    Route::post('/attendance/clock-in', [AttendanceController::class, 'clockIn'])
        ->name('attendance.clockIn');

    Route::post('/attendance/clock-out', [AttendanceController::class, 'clockOut'])
        ->name('attendance.clockOut');


    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');
});


/*
|--------------------------------------------------------------------------
| Monitor / Kiosk
|--------------------------------------------------------------------------
*/

Route::get('/monitor', [MonitorController::class, 'monitor'])
    ->name('monitor');


/*
|--------------------------------------------------------------------------
| Borrow
|--------------------------------------------------------------------------
*/

Route::post('/borrow', [MonitorController::class, 'enterBorrow'])
    ->name('borrow.enter');

Route::get('/borrow', [MonitorController::class, 'borrow'])
    ->name('borrow');


/*
|--------------------------------------------------------------------------
| Return
|--------------------------------------------------------------------------
*/

Route::post('/return', [MonitorController::class, 'enterReturn'])
    ->name('return.enter');

Route::get('/return', [MonitorController::class, 'return'])
    ->name('return');


/*
|--------------------------------------------------------------------------
| Reserve
|--------------------------------------------------------------------------
*/

Route::get('/reserve', [MonitorController::class, 'reserve'])
    ->name('reserve');

    /*
|--------------------------------------------------------------------------
Book
|--------------------------------------------------------------------------
*/
    Route::middleware('auth')->group(function () {

    Route::get('/books', [BookController::class, 'index'])
        ->name('book');

    Route::post('/books', [BookController::class, 'store'])
        ->name('books.store');

    Route::put('/books/{book}', [BookController::class, 'update'])
        ->name('books.update');

    Route::delete('/books/{book}', [BookController::class, 'destroy'])
        ->name('books.destroy');

});

   /*
|--------------------------------------------------------------------------
Book Reservation
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| STUDENT BOOK RESERVATION
|--------------------------------------------------------------------------
*/

Route::get('/reserve', [
    BookReservationController::class,
    'create'
])->name('reserve');

Route::post('/reserve', [
    BookReservationController::class,
    'store'
])->name('reserve.store');


/*
|--------------------------------------------------------------------------
| AUTHENTICATED / ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | BOOK BORROW
    |--------------------------------------------------------------------------
    */

    Route::get('/bookborrow', [
        BookController::class,
        'borrow'
    ])->name('bookborrow');


    Route::put('/bookborrow/{id}/return', [
        BookController::class,
        'returnBook'
    ])->name('bookborrow.return');


    /*
    |--------------------------------------------------------------------------
    | RESERVATION MONITORING
    |--------------------------------------------------------------------------
    */

    Route::get('/reserve-monitoring', [
        BookReservationController::class,
        'index'
    ])->name('reserve.monitoring');


    Route::put('/reserve-monitoring/{id}/ready', [
        BookReservationController::class,
        'ready'
    ])->name('reserve.ready');


    Route::put('/reserve-monitoring/{id}/pickup', [
        BookReservationController::class,
        'pickup'
    ])->name('reserve.pickup');


    Route::put('/reserve-monitoring/{id}/cancel', [
        BookReservationController::class,
        'cancel'
    ])->name('reserve.cancel');

});