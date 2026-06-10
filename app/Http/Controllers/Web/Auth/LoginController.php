<?php

namespace App\Http\Controllers\Web\Auth;

use App\Enums\TokenAbility;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class LoginController extends Controller
{
    /**
     * Обработать вход пользователя по форме.
     */
    public function login(Request $request)
    {
        $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Найти пользователя по логину
        $user = User::where('login', $request->login)->first();

        if (! $user) {
            return redirect()->route('auth.login')
                ->withErrors(['login' => __('Пользователь не существует.')]);
        }

        // Проверить пароль
        if (! Hash::check($request->password, $user->password)) {
            return redirect()->route('auth.login')
                ->withErrors(['password' => __('Неверный логин или пароль.')]);
        }

        // Авторизовать пользователя (Laravel автоматически создаст сессию)
        auth()->guard('web')->login($user, $request->boolean('remember'));

        // Создать токен Sanctum для API доступа
        $access_token = $user->createToken(
            'web_session',
            [TokenAbility::ACCESS_API->value]
        )->plainTextToken;

        // Сохранить токен в сессии для восстановления при новых запросах
        session()->put('auth_token', $access_token);

        return redirect()->route('calendar.index')
            ->withSuccess(__('Вы успешно вошли в систему!'))
            ->withInput($request->only('login', 'remember'));
    }

    /**
     * Обработать регистрацию пользователя.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'login' => [
                'required',
                'string',
                'unique:users,login',
            ],
            'password' => [
                'required',
                'string',
                Password::defaults(),
            ],
        ]);

        // Создать нового пользователя (Laravel сам проверит уникальность логина)
        $user = User::create([
            'login' => $request->login,
            'password' => Hash::make($request->password),
        ]);

        // Создать токен Sanctum для API доступа
        $access_token = $user->createToken(
            'web_session',
            [TokenAbility::ACCESS_API->value]
        )->plainTextToken;

        // Авторизовать пользователя
        auth()->guard('web')->login($user);

        // Сохранить токен в сессии
        session()->put('auth_token', $access_token);

        return redirect()->route('calendar.index')
            ->withSuccess(__('Вы успешно зарегистрировались!'))
            ->withInput(['login' => $request->login]);
    }
}
