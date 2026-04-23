<?php

namespace App\Http\Controllers\Api\Auth;

use App\Enums\TokenAbility;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('login', $request->login)->first();
        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => __('Неверный логин или пароль.'),
            ], 422);
        } elseif (! Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => __('Пароль неверен.'),
            ], 422);
        }

        $access_token = $user->createToken('access_token', [TokenAbility::ACCESS_API->value])->plainTextToken;

        return response()->json([
            'data' => [
                'access_token' => $access_token,
            ],
            'success' => true,
        ]);
    }
}
