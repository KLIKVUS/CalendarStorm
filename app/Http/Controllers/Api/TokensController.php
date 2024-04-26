<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Enums\TokenAbility;
use App\Http\Controllers\Controller;

class TokensController extends Controller
{
    public function createUserTokens(User $user) {
        $access_token = $user->createToken('access_token', [TokenAbility::ACCESS_API->value], config('sanctum.expiration'))->plainTextToken;
        $refresh_token = $user->createToken('refresh_token', [TokenAbility::ISSUE_ACCESS_TOKEN->value], config('sanctum.rt_expiration'))->plainTextToken;

        return [
            'access_token' => $access_token,
            'refresh_token' => $refresh_token,
        ];
    }
}
