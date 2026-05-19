<?php

namespace App\Http\Controllers\Web\Auth;

use App\Enums\TokenAbility;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * Обработать регистрацию пользователя по форме.
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
        auth()->login($user);

        // Сохранить токен в сессии
        session()->put('auth_token', $access_token);

        return redirect()->route('calendar.index')
            ->withSuccess(__('Вы успешно зарегистрировались!'))
            ->withInput(['login' => $request->login]);
    }
}
