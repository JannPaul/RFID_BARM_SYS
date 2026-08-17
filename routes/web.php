<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\MonitorController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookReservationController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\StudentPersonnelController;
use App\Http\Controllers\StudentPersonnelManagementController;

/*
|--------------------------------------------------------------------------
| GUEST ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/', [
        LoginController::class,
        'showLoginForm'
    ]);

    Route::get('/login', [
        LoginController::class,
        'showLoginForm'
    ])->name('login');

    Route::post('/login', [
        LoginController::class,
        'login'
    ])->name('login.authenticate');

});


/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
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
    | PROFILE
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', function () {

        return view('profile');

    })->name('profile');


    /*
|--------------------------------------------------------------------------
| STUDENT & PERSONNEL MANAGEMENT
|--------------------------------------------------------------------------
*/

Route::get('/student-personnel-management', [
    StudentPersonnelManagementController::class,
    'index'
])->name('studentpersonnel.management');


/*
|--------------------------------------------------------------------------
| STUDENT CRUD
|--------------------------------------------------------------------------
*/

Route::post('/student-personnel-management/students', [
    StudentPersonnelManagementController::class,
    'storeStudent'
])->name('management.students.store');


Route::put('/student-personnel-management/students/{student}', [
    StudentPersonnelManagementController::class,
    'updateStudent'
])->name('management.students.update');


Route::delete('/student-personnel-management/students/{student}', [
    StudentPersonnelManagementController::class,
    'destroyStudent'
])->name('management.students.destroy');


/*
|--------------------------------------------------------------------------
| PERSONNEL CRUD
|--------------------------------------------------------------------------
*/

Route::post('/student-personnel-management/personnel', [
    StudentPersonnelManagementController::class,
    'storePersonnel'
])->name('management.personnel.store');


Route::put('/student-personnel-management/personnel/{personnel}', [
    StudentPersonnelManagementController::class,
    'updatePersonnel'
])->name('management.personnel.update');


Route::delete('/student-personnel-management/personnel/{personnel}', [
    StudentPersonnelManagementController::class,
    'destroyPersonnel'
])->name('management.personnel.destroy');
    /*
    |--------------------------------------------------------------------------
    | USER MANAGEMENT
    |--------------------------------------------------------------------------
    */

    Route::get('/user-management', [
        UserManagementController::class,
        'index'
    ])->name('user.management');


    Route::post('/user-management/staff', [
        UserManagementController::class,
        'store'
    ])->name('staff.store');


    Route::put('/user-management/staff/{user}', [
        UserManagementController::class,
        'update'
    ])->name('staff.update');


    Route::delete('/user-management/staff/{user}', [
        UserManagementController::class,
        'destroy'
    ])->name('staff.destroy');


    /*
    |--------------------------------------------------------------------------
    | STUDENT MONITORING
    |--------------------------------------------------------------------------
    */

    Route::get('/students', [
        StudentPersonnelController::class,
        'students'
    ])->name('students.monitoring');


    /*
    |--------------------------------------------------------------------------
    | PERSONNEL MONITORING
    |--------------------------------------------------------------------------
    */

    Route::get('/personnel', [
        StudentPersonnelController::class,
        'personnel'
    ])->name('personnel.monitoring');


    /*
    |--------------------------------------------------------------------------
    | BOOK MANAGEMENT
    |--------------------------------------------------------------------------
    */

    Route::get('/books', [
        BookController::class,
        'index'
    ])->name('book');


    Route::post('/books', [
        BookController::class,
        'store'
    ])->name('books.store');


    Route::put('/books/{book}', [
        BookController::class,
        'update'
    ])->name('books.update');


    Route::delete('/books/{book}', [
        BookController::class,
        'destroy'
    ])->name('books.destroy');


    /*
    |--------------------------------------------------------------------------
    | BOOK BORROW MONITORING
    |--------------------------------------------------------------------------
    */

    Route::get('/bookborrow', [
        BookController::class,
        'borrowMonitoring'
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


    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [
        LoginController::class,
        'logout'
    ])->name('logout');

});


/*
|--------------------------------------------------------------------------
| PUBLIC KIOSK
|--------------------------------------------------------------------------
*/

Route::get('/monitor', [
    MonitorController::class,
    'monitor'
])->name('monitor');


/*
|--------------------------------------------------------------------------
| RFID ATTENDANCE
|--------------------------------------------------------------------------
|
| IMPORTANT:
| Keep this OUTSIDE Route::middleware('auth')
| because the RFID kiosk needs to access it without logging in.
|
*/

Route::post('/attendance/scan', [
    AttendanceController::class,
    'scanRfid'
])->name('attendance.scan');


/*
|--------------------------------------------------------------------------
| BORROW KIOSK
|--------------------------------------------------------------------------
*/

Route::post('/borrow-enter', function () {

    session([
        'borrow_kiosk_access' => true
    ]);

    return redirect()
        ->route('borrow.kiosk');

})->name('borrow.enter');


Route::get('/borrowkiosk', function () {

    /*
     * Prevent users from opening the borrow kiosk directly.
     */

    if (!session('borrow_kiosk_access')) {

        return redirect()
            ->route('monitor')
            ->with(
                'error',
                'Please click the BORROW button first.'
            );
    }


    /*
     * Load the borrowing form from BookController.
     */

    return app(BookController::class)
        ->borrowForm();

})->name('borrow.kiosk');


Route::post('/borrowkiosk/confirm', [
    BookController::class,
    'storeBorrow'
])->name('borrow.store');


Route::get('/borrowkiosk/exit', function () {

    /*
     * Remove kiosk access session.
     */

    session()->forget(
        'borrow_kiosk_access'
    );


    /*
     * Return to main monitor.
     */

    return redirect()
        ->route('monitor');

})->name('borrow.exit');


/*
|--------------------------------------------------------------------------
| RETURN KIOSK
|--------------------------------------------------------------------------
*/

Route::post('/return', [
    MonitorController::class,
    'enterReturn'
])->name('return.enter');


Route::get('/return', [
    MonitorController::class,
    'return'
])->name('return');


/*
|--------------------------------------------------------------------------
| RESERVE KIOSK
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