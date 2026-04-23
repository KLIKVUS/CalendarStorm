<?php

use App\Http\Controllers\Auth\LoginFormController;
use App\Http\Controllers\Auth\RegisterFormController;
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

Route::prefix('/auth')->name('auth.')->group(function () {
    Route::get('/', fn() => redirect()->route('auth.login'))->name('index')->middleware(['guest']);

    // Маршруты для гостей - страницы входа/регистрации
    Route::view('/login', 'pages.auth.index', ['tab' => 'login', 'title' => __('Login')])
        ->name('login')->middleware(['guest']);
    Route::view('/register', 'pages.auth.index', ['tab' => 'register', 'title' => __('Register')])
        ->name('register')->middleware(['guest']);

    // Маршруты для обработки POST форм входа и регистрации
    Route::post('/login', [LoginFormController::class, 'login'])->middleware(['guest']);
    Route::post('/register', [RegisterFormController::class, 'register'])->middleware(['guest']);

    // Маршрут выхода из системы для всех пользователей
    Route::post('/logout', function () {
        auth()->guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()
            ->route('home.index')
            ->withSuccess(__('Вы успешно вышли из системы.'));
    })->name('logout')->middleware(['auth:sanctum']);
});

// Главная страница
Route::view('/', 'pages.home.index')->name('home.index');

// Календарь - главная страница приложения
Route::view('/calendar', 'pages.calendar.index')->name('calendar.index');

// Все остальное приложение доступно только авторизованным пользователям
Route::middleware(['auth:sanctum'])->group(function () {
    // API контроллеры для управления календарями и событиями (можно использовать Laravel Echo для реального времени)
});
