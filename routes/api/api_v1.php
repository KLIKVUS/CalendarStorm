<?php

use App\Enums\TokenAbility;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\EventsController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\v1\CalendarController;
use App\Http\Controllers\Api\Auth\RefreshController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\v1\UserCalendarController;
use App\Http\Controllers\Api\v1\CalendarEventController;

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
        Route::delete('/refresh', [RefreshController::class, 'destroy'])->name('refresh.destroy')->middleware(['ability:' . TokenAbility::ISSUE_ACCESS_TOKEN->value]);
    });
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
        Route::put('/{calendar}', [CalendarController::class, 'update'])->name('update');
        Route::delete('/{calendar}', [CalendarController::class, 'delete'])->name('delete');
    });

    Route::prefix('/{calendar}/events')->name('events.')->group(function () {
        Route::get('/', [CalendarEventController::class, 'index'])->name('index');
    
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/', [CalendarEventController::class, 'store'])->name('store');
        });
    });
});

Route::prefix('/events')->name('events.')->group(function () {
    Route::get('/', [EventsController::class, 'index'])->name('index');
    Route::get('/{calendar}', [EventsController::class, 'show'])->name('show');

    Route::middleware('auth:sanctum')->group(function () {
        Route::put('/{calendar}', [EventsController::class, 'update'])->name('update');
        Route::delete('/{calendar}', [EventsController::class, 'delete'])->name('delete');
    });
});
