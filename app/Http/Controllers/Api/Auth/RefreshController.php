<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;

class RefreshController extends Controller
{
    public function store()
    {
        $user = auth()->user();

        return response()->json([
            'data' => [
                'access_token' => $user->createToke('access_token')->plainTextToken,
                'refresh_token' => $user->createToken('refresh_token', ['tokens:refresh'])->plainTextToken,
            ],
            'success' => true,
        ]);
    }
}
