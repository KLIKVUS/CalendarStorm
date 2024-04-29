<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Enums\TokenAbility;
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

        $access_token = $user->createToken('access_token', [TokenAbility::ACCESS_API->value])->plainTextToken;

        return response()->json([
            'data' => [
                'access_token' => $access_token,
            ],
            'success' => true,
        ]);
    }
}
