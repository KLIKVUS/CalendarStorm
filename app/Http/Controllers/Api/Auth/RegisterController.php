<?php

namespace App\Http\Controllers\Api\Auth;

use App\Enums\TokenAbility;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string', Password::defaults()],
        ]);

        $user = User::where('login', $request->login)->first();
        if ($user) {
            return response()->json([
                'success' => false,
                'message' => 'Данный логин занят.',
            ], 422);
        }

        $newUser = User::create($validated);

        $access_token = $newUser->createToken('access_token', [TokenAbility::ACCESS_API->value])->plainTextToken;

        return response()->json([
            'data' => [
                'access_token' => $access_token,
            ],
            'success' => true,
        ], 201);
    }
}
