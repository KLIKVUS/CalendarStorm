<?php

use App\Http\Controllers\Web\Auth\LoginController;
use App\Http\Controllers\Web\Auth\RegisterController;
use App\Models\Calendar;
use App\Models\User;
use Illuminate\Http\Request;
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
    // Маршруты для гостей
    Route::middleware(['guest'])->group(function () {
        Route::get('/', fn () => redirect()->route('auth.login'))->name('index');

        // Страницы входа/регистрации
        Route::view('/login', 'pages.auth.index', ['tab' => 'login', 'title' => __('Login')])->name('login');
        Route::view('/register', 'pages.auth.index', ['tab' => 'register', 'title' => __('Register')])->name('register');

        // Маршруты для обработки POST форм входа и регистрации
        Route::post('/login', [LoginController::class, 'login']);
        Route::post('/register', [RegisterController::class, 'register']);
    });

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

// Календарь
Route::view('/calendar', 'pages.calendar.index')->name('calendar.index');

// Профиль пользователя
Route::get('/profile/{user}', function (Request $request, User $user) {
    $calendars = Calendar::where('owner_id', $user->id)
        ->paginate(10);

    $calendar = null;

    if ($request->filled('cal')) {
        $calendar = $request->filled('cal') ? Calendar::where('owner_id', $user->id)
            ->findOrFail($request->query('cal')) : null;
    }

    return view('pages.profile.index', compact('user', 'calendars', 'calendar'));
})->name('profile.index');

// Все остальное приложение доступно только авторизованным пользователям
Route::middleware(['auth:sanctum'])->group(function () {
    Route::delete('/calendars/{calendar}', function (Calendar $calendar) {
        abort_unless(
            $calendar->owner_id === auth()->id(),
            403
        );

        $calendar->delete();

        return redirect()
            ->route('profile.index', auth()->user())
            ->with('success', 'Календарь удалён');
    })->middleware('auth')->name('calendars.destroy');
});
