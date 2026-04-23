<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\v1\CalendarController;
use App\Http\Controllers\Api\v1\CalendarEventController;
use App\Http\Controllers\Api\v1\EventsController;
use App\Http\Controllers\Api\v1\UserCalendarController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('/auth')->name('auth.')->middleware('guest:sanctum')->group(function () {
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

Route::prefix('/user/{user}')->name('user.')->group(function () {
    Route::get('/', function (int $user_id) {
        return $user_id;
    })->name('index');

    Route::prefix('/calendars')->name('calendars.')->group(function () {
        Route::get('/', [UserCalendarController::class, 'index'])->name('index');
    });
});

Route::prefix('/calendars')->name('calendars.')->group(function () {
    Route::get('/', [CalendarController::class, 'index'])->name('index');
    Route::get('/{calendar}', [CalendarController::class, 'show'])->name('show');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [CalendarController::class, 'store'])->name('store');
        Route::put('/{calendar}', [CalendarController::class, 'update'])->can('update', 'calendar')->name('update');
        Route::delete('/{calendar}', [CalendarController::class, 'destroy'])->can('delete', 'calendar')->name('destroy');
    });

    Route::prefix('/{calendar}/events')->name('events.')->group(function () {
        Route::get('/', [CalendarEventController::class, 'index'])->name('index');

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/', [CalendarEventController::class, 'store'])->can('create', 'calendar')->name('store');
        });
    });
});

Route::prefix('/events')->name('events.')->group(function () {
    Route::get('/', [EventsController::class, 'index'])->name('index');
    Route::get('/{event}', [EventsController::class, 'show'])->name('show');

    Route::middleware('auth:sanctum')->group(function () {
        Route::put('/{event}', [EventsController::class, 'update'])->can('update', 'event')->name('update');
        Route::delete('/{event}', [EventsController::class, 'destroy'])->can('delete', 'event')->name('destroy');
    });
});
