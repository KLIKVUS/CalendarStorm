<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\Api\TokensController;

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
    
        $tokens = (new TokensController())->createUserTokens($newUser);

        return response()->json([
            'data' => $tokens,
            'success' => true,
        ], 201);
    }
}
