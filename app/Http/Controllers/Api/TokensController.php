<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Enums\TokenAbility;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class TokensController extends Controller
{
    public function createUserTokens(User $user) {
        $refresh_token_expiresAt = Carbon::now()->addMinutes(config('sanctum.rt_expiration'));
        $access_token = $user->createToken('access_token', [TokenAbility::ACCESS_API->value])->plainTextToken;
        $refresh_token = $user->createToken('refresh_token', [TokenAbility::ISSUE_ACCESS_TOKEN->value], $refresh_token_expiresAt)->plainTextToken;

        return [
            'access_token' => $access_token,
            'refresh_token' => $refresh_token,
        ];
    }
}
