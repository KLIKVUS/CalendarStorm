<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => __('auth.failed'),
            ], 422);
        } elseif (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => __('auth.password'),
            ], 422);
        }

        return response()->json([
            'data' => [
                'access_token' => $user->createToken('access_token')->plainTextToken,
                'refresh_token' => $user->createToken('refresh_token', ['tokens:refresh'])->plainTextToken,
            ],
            'success' => true,
        ]);
    }
}
