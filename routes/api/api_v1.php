<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RefreshController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\v1\CalendarController;
use App\Http\Controllers\Api\v1\UserCalendarController;

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

Route::prefix('/auth')->name('auth.')->group(function () {
    Route::middleware('guest:sanctum')->group(function () {
        Route::post('/login', [LoginController::class, 'store'])->name('login.store');
        Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::delete('/logout', [LogoutController::class, 'destroy'])->name('logout.destroy');
        Route::delete('/refresh', [RefreshController::class, 'destroy'])->name('refresh.destroy');
    });
});

Route::prefix('/user/{user}')->name('user.')->group(function () {
    Route::get('/', function (int $user_id) {
        return $user_id;
    })->name('index');

    Route::prefix('/calendars')->name('calendars.')->group(function () {
        Route::get('/', [UserCalendarController::class, 'index'])->name('index');
    });

    Route::prefix('/events')->name('events.')->group(function () {
        Route::get('/', [UserCalendarController::class, 'index'])->name('index');
    });
});

Route::prefix('/calendars')->name('calendars.')->group(function () {
    Route::get('/', [CalendarController::class, 'index'])->name('index');
    Route::get('/{calendar}', [CalendarController::class, 'show'])->name('show');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [CalendarController::class, 'store'])->name('store');
        Route::put('/{calendar}', [CalendarController::class, 'update'])->name('update');
        Route::delete('/{calendar}', [CalendarController::class, 'delete'])->name('delete');
    });
});

Route::prefix('/events')->name('events.')->group(function () {
    Route::get('/', [CalendarController::class, 'index'])->name('index');
    Route::get('/{calendar}', [CalendarController::class, 'show'])->name('show');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [CalendarController::class, 'store'])->name('store');
        Route::put('/{calendar}', [CalendarController::class, 'update'])->name('update');
        Route::delete('/{calendar}', [CalendarController::class, 'delete'])->name('delete');
    });
});
