<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\TokensController;

class RefreshController extends Controller
{
    public function store()
    {
        $user = auth()->user();
        $tokens = (new TokensController())->createUserTokens($user);

        return response()->json([
            'data' => $tokens,
            'success' => true,
        ]);
    }
}
